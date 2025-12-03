<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use App\Models\StockIn;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexTambah()
    {
        $rawMaterials = BahanBaku::all();
        $title = 'Halaman Transaksi';

        return view('admin.transaksis.stok-masuk', compact('rawMaterials', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createTambah($bahan_baku_kd)
    {
        $material = BahanBaku::where('bahan_baku_kd', $bahan_baku_kd)->firstOrFail();
        $title = 'Form Transaksi Stok Masuk';

        return view('admin.transaksis.tambah-stock', compact('material', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTambah(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $bahan_baku = BahanBaku::findOrFail($request->bahan_baku_id);
        $bahan_baku->increment('stock', $request->jumlah);

        // Generate kode transaksi masuk
        $tanggal = now()->format('ymd');
        $prefix = 'TRX-IN-';

        $countToday = StockIn::whereDate('created_at', now())
            ->count() + 1;

        $nomorUrut = str_pad($countToday, 3, '0', STR_PAD_LEFT);

        $kodeTransaksi = $prefix . $tanggal . '-' . $nomorUrut;

        StockIn::create([
            'bahan_baku_id' => $request->bahan_baku_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'kode_transaksi' => $kodeTransaksi,
        ]);

        return redirect()->route('admin.transaksis.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function riwayat(Request $request)
    {
        $query = StockIn::with('rawMaterial');

        $title = 'riwayat transaksi';


        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transaksis = $query->latest()->paginate(10);

        return view('admin.transaksis.riwayat', compact('transaksis', 'title', 'transaksis'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
