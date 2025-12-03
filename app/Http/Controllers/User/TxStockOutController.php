<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\StockOut;
use App\Models\DetailOut;
use App\Models\RawMaterial;
use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TxStockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = Project::all();
        $raw_material = BahanBaku::all();
        $title = 'Form Transaksi Out';

        return view('user.transaksis.stock-out', compact('project', 'raw_material', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Authenticatable $user)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_pengeluaran' => 'required|in:produksi,rusak,hilang,lainnya',
            'bahan_baku_id.*' => 'required|exists:raw_materials,id',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $tanggal_keluar = now();
        $kode = $this->generateStockOutKode($request->jenis_pengeluaran);

        $rawMaterials = $request->input('bahan_baku_id', []);
        $jumlahs = $request->input('jumlah', []);
        $keterangans = $request->input('detail_keterangan', []);


        foreach ($rawMaterials as $index => $bahanId) {
            $material = BahanBaku::find($bahanId);
            $jumlahKeluar = (int) ($jumlahs[$index] ?? 0);

            if (!$material) {
                return back()->withErrors(['msg' => "Bahan baku ID $bahanId tidak ditemukan."]);
            }

            if ($material->stock < $jumlahKeluar) {
                return back()->withErrors(['msg' => "Stock untuk bahan '{$material->name}' tidak mencukupi."]);
            }
        }


        $stockOut = StockOut::create([
            'user_id' => $user->id, // Injected user
            'stock_out_kode' => $kode,
            'project_id' => $request->jenis_pengeluaran === 'produksi' ? $request->project_id : null,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'keterangan' => $request->keterangan,
            'tanggal_keluar' => $tanggal_keluar,
        ]);


        foreach ($rawMaterials as $index => $bahanId) {
            $jumlahKeluar = (int) ($jumlahs[$index] ?? 0);
            $keterangan = $keterangans[$index] ?? null;

            DetailOut::create([
                'stock_out_id' => $stockOut->id,
                'bahan_baku_id' => $bahanId,
                'jumlah' => $jumlahKeluar,
                'keterangan' => $keterangan,
            ]);

            $material = BahanBaku::find($bahanId);
            $material->decrement('stock', $jumlahKeluar);
        }



        return redirect()->route('user.transaksis.history-out')->with('success', 'Transaksi stock keluar berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Authenticatable $user)
    {
        $stockOut = StockOut::with(['project', 'detailOuts.rawMaterial'])->findOrFail($id);

        // Cek apakah user yang sedang login adalah pemilik data
        if ($stockOut->user_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses data ini.');
        }

        return view('user.transaksis.detail-out', compact('stockOut'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function history(Request $request, Authenticatable $user)
    {
        $query = StockOut::with(['project', 'detailOuts'])
            ->where('user_id', $user->id); // ⬅️ Filter user

        // Filter tanggal mulai
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->whereDate('tanggal_keluar', '>=', $startDate);
        }

        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereDate('tanggal_keluar', '<=', $endDate);
        }

        // Filter jenis pengeluaran
        if ($request->filled('jenis_pengeluaran')) {
            $query->where('jenis_pengeluaran', $request->jenis_pengeluaran);
        }

        $stockOuts = $query->latest()->simplePaginate(5);

        return view('user.transaksis.history-out', compact('stockOuts'));
    }


    private function generateStockOutKode($jenis)
    {
        $prefix = 'TRX-SO';
        $jenisKode = [
            'produksi' => 'PRD',
            'rusak' => 'RSK',
            'hilang' => 'HLG',
            'lainnya' => 'LNN',
        ];

        $today = Carbon::now()->format('dmy');

        $latest = StockOut::whereDate('created_at', Carbon::today())
            ->where('jenis_pengeluaran', $jenis)
            ->orderBy('id', 'desc')
            ->first();

        if ($latest && preg_match('/(\d+)$/', $latest->stock_out_kode, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf('%s-%s-%s-%03d', $prefix, $jenisKode[$jenis], $today, $nextNumber);
    }
}
