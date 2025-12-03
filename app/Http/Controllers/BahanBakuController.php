<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Unit;
use App\Models\Category;
use App\Models\RawMaterial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BahanBaku::with(['category', 'unit']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('bahan_baku_kd', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        $units = Unit::all();
        $categories = Category::all();

        $materials = $query->simplePaginate(5);

        $title = 'Bahan Baku';
        return view('admin.bahanBakus.index', compact('materials', 'title', 'units', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $categories = Category::all();
    //     $units = Unit::all();
    //     $title = 'Tambah Material';
    //     return view('admin.rawMaterials.tambah', compact('categories', 'units', 'title'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'stock' => 'required|integer|min:1',
            'min_stock' => 'required|integer|min:1',
        ]);

        $category = Category::findOrFail($request->category_id);
        $categoryCode = strtoupper(Str::substr($category->name, 0, 3));

        // Ambil kata terakhir dari nama bahan baku
        $words = explode(' ', trim($request->name));
        $lastWord = end($words);
        $nameCode = strtoupper(Str::substr(preg_replace('/[^A-Za-z]/', '', $lastWord), 0, 3));

        $prefix = "{$categoryCode}-{$nameCode}";

        $latest = BahanBaku::where('bahan_baku_kd', 'like', "{$prefix}-%")
            ->orderBy('bahan_baku_kd', 'desc')
            ->first();

        if ($latest) {
            $lastNumber = (int) substr($latest->bahan_baku_kd, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $kode = "{$prefix}-{$nextNumber}";
        BahanBaku::create([
            'bahan_baku_kd' => $kode,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
        ]);

        return redirect()->route('admin.rawMaterials.index')->with('success', 'Material berhasil ditambahkan.');
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
        // $material = BahanBaku::findOrFail($id);
        // $categories = Category::all();
        // $units = Unit::all();
        // $title = 'Form Edit Kategori';

        // return view('admin.rawMaterials.edit', compact('material', 'categories', 'units', 'title'));

        $material = BahanBaku::with(['category', 'unit'])->findOrFail($id);

        return response()->json($material);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = BahanBaku::findOrFail($id);
        $validated = $request->validate([
            'bahan_baku_kd' => 'required|string|unique:bahan_bakus,bahan_baku_kd,' . $id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'stock' => 'required|integer|min:1',
            'min_stock' => 'required|integer|min:1',
        ]);

        $material->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Bahan baku berhasil diubah.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = BahanBaku::findOrFail($id);
        $material->delete();

        return redirect()->route('admin.rawMaterials.index')
            ->with('success', 'Material berhasil dihapus.');
    }


    //user

    public function userIndex(Request $request)
    {
        $query = BahanBaku::with(['category', 'unit']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('bahan_baku_kd', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }

        $materials = $query->paginate(5);
        // $categories = Category::all();
        // $units = Unit::all();
        $title = 'Bahan Baku';
        return view('user.rawMaterials.index', compact('materials', 'title'));
    }
}
