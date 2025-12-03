<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->filled('search')) {
            $query->Where('name', 'like', '%' . $request->search . '%');
        };

        $units = $query->paginate(5);
        $title = 'Halaman Satuan';
        return view('admin.units.index', compact('units', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Halaman Satuan';
        return view('admin.units.tambah', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
        ]);

        Unit::create($validated);

        return redirect()->route('admin.units.index')->with('success', 'Satuan berhasil ditambahkan.');
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
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:150',
        ]);

        $unit->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Satuan berhasil diubah.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);

        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
