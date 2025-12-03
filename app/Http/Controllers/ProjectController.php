<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Project::query();

        // Search berdasarkan nama project atau customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('project_kode', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->orderBy('created_at', 'desc')->get();


        $title = 'Halaman Project';
        return view('admin.projects.index', compact('projects', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Project';
        return view('admin.projects.tambah-project', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'in:on progress,selesai,dibatalkan'
        ]);

        $now = Carbon::now();
        $month = $now->format('m');
        $year = $now->format('y');
        $prefix = "PRJ-{$month}{$year}-";

        $count = Project::where('project_kode', 'like', $prefix . '%')->count();

        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);


        $projectKode = $prefix . $sequence;


        Project::create([
            'project_kode' => $projectKode,
            'name' => $request->name,
            'customer_name' => $request->customer_name,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status ?? 'on progress',
        ]);

        return redirect()->route('projects.index')->with('success',  'Project Telah Dibuat');
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
        $project = Project::findOrFail($id);

        return response()->json([
            'id' => $project->id,
            'project_kode' => $project->project_kode,
            'name' => $project->name,
            'customer_name' => $project->customer_name,
            'tanggal_mulai' => $project->tanggal_mulai->format('Y-m-d'),
            'status' => $project->status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'status' => 'in:on progress,selesai,dibatalkan'
        ]);

        $statusBaru = $request->status;


        if ($project->status === 'selesai' && $statusBaru !== 'selesai') {
            $errorMsg = 'Project yang sudah selesai tidak bisa diubah statusnya.';

            if ($request->ajax()) {
                return response()->json(['error' => $errorMsg], 422);
            }

            return back()->withErrors(['status' => $errorMsg]);
        }

        $tanggalSelesai = $project->tanggal_selesai;


        if (in_array($statusBaru, ['selesai', 'dibatalkan']) && !$project->tanggal_selesai) {
            $tanggalSelesai = Carbon::now();
        }

        $project->update([
            'name' => $request->name,
            'customer_name' => $request->customer_name,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $tanggalSelesai,
            'status' => $statusBaru,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Project berhasil diubah.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return back()
            ->with('success', 'Project berhasil dihapus.');
    }
}
