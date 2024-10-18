<?php

namespace App\Http\Controllers;

use App\Imports\GroupImport;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            Excel::import(new GroupImport(), $request->file('file'));
            session()->flash('success', 'Berhasil menambahkan Data Group');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::findOrFail($id);
        return view('group.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

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
        try {
            $group = Group::findOrFail($id);
            $group->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data group']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteAll()
    {
        try {
            DB::table('groups')->truncate();

            // Menampilkan pesan sukses
            session()->flash('success', 'Semua data berhasil dihapus.');
            return response()->json(['success' => true, 'message' => 'Semua data berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            // Menangani error
            session()->flash('error', $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
