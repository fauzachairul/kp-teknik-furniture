<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\StockIn;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Category;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LaporanController extends Controller
{

    public function rawMaterials(Request $request)
    {
        $query = BahanBaku::with(['category', 'unit']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $units = Unit::all();
        $categories = Category::all();

        $materials = $query->paginate(5);
        $title = 'Bahan Baku';
        return view('admin.laporan.bahan-baku', compact('materials', 'title', 'units', 'categories'));
    }

    public function stockOuts(Request $request)
    {
        $query = StockOut::with(['project', 'detailOuts']);

        // Filter tanggal mulai dan akhir
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Filter jenis pengeluaran
        if ($request->filled('jenis_pengeluaran')) {
            $query->where('jenis_pengeluaran', $request->jenis_pengeluaran);
        }

        $stockOuts = $query->latest()->get();

        return view('admin.laporan.stock-outs', compact('stockOuts'));
    }

    public function stockIns(Request $request)
    {
        $query = StockIn::query();

        // Filter tanggal mulai dan akhir
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereDate('created_at', '<=', $endDate);
        }

        $stockIns = $query->latest()->get();

        return view('admin.laporan.stock-ins', compact('stockIns'));
    }

    public function rm_view_pdf(Request $request)
    {
        $query = BahanBaku::with(['category', 'unit']);

        $categoryId = $request->category;
        $categoryName = 'Semua';

        if ($request->filled('category')) {
            $query->where('category_id', $categoryId);

            $categoryModel = Category::find($categoryId);
            if ($categoryModel) {
                $categoryName = $categoryModel->name;
            }
        }

        $rawMaterials = BahanBaku::all();
        $units = Unit::all();
        $categories = Category::all();
        $hariIni = now();
        $data = [

            'rawMaterials' => $rawMaterials,
            'logoPath' => asset('img/logo2.png'),
            'search' => $request->search,
            'categoryId' => $categoryId,
            'categoryName' => $categoryName,
            'units' => $units,
            'categories' => $categories,
            'hariIni' => $hariIni,
        ];
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L' // L  Landscape, P Portrait
        ]);
        $html = View::make('admin.laporan.pdf.bahan-baku-pdf', $data)->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-data-bahan-baku.pdf', 'D');
    }

    public function so_view_pdf(Request $request)
    {
        $query = StockOut::with(['project', 'detailOuts.rawMaterial']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('jenis_pengeluaran')) {
            $query->where('jenis_pengeluaran', $request->jenis_pengeluaran);
        }

        $stockOuts = $query->orderBy('tanggal_keluar', 'desc')->get();

        $data = [
            'stockOuts' => $stockOuts,
            'logoPath' => asset('img/logo2.png'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
        ];

        // return view('admin.laporan.pdf.stock-out-pdf', $data);

        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L' // L untuk Landscape, P untuk Portrait (default)
        ]);
        $html = View::make('admin.laporan.pdf.stock-out-pdf', $data)->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-transaksi-stockout.pdf', 'D');
    }
    public function si_view_pdf(Request $request)
    {
        $query = StockIn::query();

        // Filter tanggal mulai dan akhir
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereDate('created_at', '<=', $endDate);
        }

        $stockIns = $query->latest()->get();

        $data = [
            'stockIns' => $stockIns,
            'logoPath' => asset('img/logo2.png'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'L' // L untuk Landscape, P untuk Portrait (default)
        ]);
        $html = View::make('admin.laporan.pdf.stock-in-pdf', $data)->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output('laporan-transaksi-stockmasuk.pdf', 'D');
    }
}
