<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\DanaMaster;
use Illuminate\Http\Request;

class DanaMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //load view admin.master.dana.index
        $title = 'Dana DBHCHT';

        //load data
        $data = DanaMaster::latest()->get();
        return view('admin.master.dana.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //title
        $title = 'Tambah Dana DBHCHT';
        return view('admin.master.dana.tambah', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //pesan validasio
        $messages = [
            'tahun.required' => 'Tahun harus diisi',
            'nominal.required' => 'Nominal harus diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal 1000',
        ];
        //
        $request->validate([
            'tahun' => 'required',
            'nominal' => 'required|numeric|min:1000',
        ], $messages);

        //load message

        DanaMaster::create([
            'tahun' => $request->tahun,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('admin.master.dana-master')->with('success', 'Berhasil simpan data');
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
