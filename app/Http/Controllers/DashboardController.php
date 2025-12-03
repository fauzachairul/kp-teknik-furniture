<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Category;
use App\Models\DetailOut;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalTxIn = StockIn::whereDate('created_at', Carbon::today())->count();
        $totalTxOut = StockOut::whereDate('tanggal_keluar', Carbon::today())->count();

        $totalTransaksi = $totalTxIn + $totalTxOut;
        $txInHariIni = StockIn::whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $txOutHariIni = StockOut::whereDate('tanggal_keluar', Carbon::today())
            ->orderBy('tanggal_keluar', 'desc')
            ->limit(10)
            ->get();

        $title = 'Dashboard';
        $lowStockMaterials = BahanBaku::whereColumn('stock', '<', 'min_stock')->get();
        $rawMaterials = BahanBaku::count();
        $categories = Category::count();
        $units = Unit::count();

        $mostUsed = DetailOut::select('bahan_baku_id', DB::raw('SUM(jumlah) as total_terpakai'))
            ->groupBy('bahan_baku_id')
            ->with('rawMaterial')
            ->orderByDesc('total_terpakai')
            ->take(5)
            ->get();


        $filter = $request->get('filter', 'masuk');
        $transactions = [];

        if ($filter === 'keluar') {
            $transactions = DetailOut::with(['rawMaterial', 'stokKeluar'])
                ->whereHas('stokKeluar')
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->stokKeluar?->tanggal_keluar ?? '-',
                        'kode_transaksi' => $item->stokKeluar?->stock_out_kode ?? '-',
                        'bahan_baku' => $item->rawMaterial->name ?? '-',
                        'jumlah' => $item->jumlah,
                        'keterangan' => $item->keterangan,
                        'jenis' => 'keluar',
                    ];
                });
        } else {
            $transactions = StockIn::with('rawMaterial')
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => $item->created_at,
                        'kode_transaksi' => $item->kode_transaksi,
                        'bahan_baku' => $item->rawMaterial->name ?? '-',
                        'jumlah' => $item->jumlah,
                        'keterangan' => $item->keterangan,
                        'jenis' => 'masuk',

                    ];
                });
        }


        return view('admin.index', compact(
            'title',
            'txInHariIni',
            'txOutHariIni',
            'totalTransaksi',
            'lowStockMaterials',
            'rawMaterials',
            'categories',
            'units',
            'mostUsed',
            'transactions',
            'filter'
        ));
    }
}
