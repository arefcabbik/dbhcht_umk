<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\DanaMaster;
use App\Models\DanaPembagian;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class DanaPembagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //load view admin.master.dana.index
        $title = 'Pembagian Dana DBHCHT';

        //load data
        //ambil  tahun pada dana master
        $tahun = DanaMaster::select('tahun')->distinct()->get();

        $tahun_dropdown = [];
        foreach ($tahun as $t) {
            $tahun_dropdown[$t->tahun] = $t->tahun;
        }

        $data = DanaPembagian::latest()->get();
        return view('admin.master.pembagian.index', compact('title', 'tahun_dropdown', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
