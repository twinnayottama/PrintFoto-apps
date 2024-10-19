<?php

namespace App\Http\Controllers;

use App\Imports\GroupImport;
use App\Models\Group;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GroupController extends Controller
{
    use FileUploadTrait;
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
                'farmer_group' => ['required', 'string'],
                'chairman' => ['required', 'string'],
                'address' => ['required', 'string'],
                'link_foto_1' => ['required', 'image', 'max:1000', 'mimes:jpeg,jpg,png'],
                'link_foto_2' => ['required', 'image', 'max:1000', 'mimes:jpeg,jpg,png'],
            ]);

            $imageFoto1 = $this->uploadImage($request, 'link_foto_1');
            $imageFoto2 = $this->uploadImage($request, 'link_foto_2');

            $group = new Group([
                'farmer_group' => $request->farmer_group,
                'chairman' => $request->chairman,
                'address' => $request->address,
                'link_foto_1' => isset($imageFoto1) ? $imageFoto1 : 'link_foto_1',
                'link_foto_2' => isset($imageFoto2) ? $imageFoto2 : 'link_foto_2',
            ]);

            $group->save();

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

            if ($group->link_foto_1) {
                $photoPath = public_path($group->link_foto_1);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            if ($group->link_foto_2) {
                $photoPath = public_path($group->link_foto_2);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            $group->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data group']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteAll()
    {
        try {
            // Ambil semua grup
            $groups = Group::all();

            // Hapus foto dari setiap grup
            foreach ($groups as $group) {
                if ($group->link_foto_1) {
                    $photoPath = public_path($group->link_foto_1);
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                }

                if ($group->link_foto_2) {
                    $photoPath = public_path($group->link_foto_2);
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                }
            }

            DB::table('groups')->truncate();

            session()->flash('success', 'Berhasil menghapus data');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
