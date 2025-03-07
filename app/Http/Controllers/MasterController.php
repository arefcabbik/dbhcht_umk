<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urusan;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\Periode;

class MasterController extends Controller
{
    public function index()
    {
        return view('admin.master.index');
    }

    public function kesra()
    {
        return view('admin.master.kesra');
    }

    public function hukum()
    {
        return view('admin.master.hukum');
    }

    public function kesehatan()
    {
        return view('admin.master.kesehatan');
    }

    public function wajibDasar()
    {
        $urusan = Urusan::where('jenis', 'wajib_dasar')
                        ->with(['program', 'program.kegiatan', 'program.kegiatan.subKegiatan'])
                        ->get();
        return view('admin.master.urusan', compact('urusan'));
    }

    public function wajibNonDasar()
    {
        $urusan = Urusan::where('jenis', 'wajib_non_dasar')
                        ->with(['program', 'program.kegiatan', 'program.kegiatan.subKegiatan'])
                        ->get();
        return view('admin.master.urusan', compact('urusan'));
    }

    public function pilihan()
    {
        $urusan = Urusan::where('jenis', 'pilihan')
                        ->with(['program', 'program.kegiatan', 'program.kegiatan.subKegiatan'])
                        ->get();
        return view('admin.master.urusan', compact('urusan'));
    }

    public function penunjang()
    {
        $urusan = Urusan::where('jenis', 'penunjang')
                        ->with(['program', 'program.kegiatan', 'program.kegiatan.subKegiatan'])
                        ->get();
        return view('admin.master.urusan', compact('urusan'));
    }

    // CRUD Urusan
    public function storeUrusan(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:urusan',
            'nama' => 'required',
            'jenis' => 'required|in:wajib_dasar,wajib_non_dasar,pilihan,penunjang'
        ]);

        $urusan = Urusan::create($request->all());
        return response()->json($urusan);
    }

    // CRUD Program
    public function storeProgram(Request $request)
    {
        $request->validate([
            'urusan_id' => 'required|exists:urusan,id',
            'kode' => 'required|unique:program',
            'nama' => 'required'
        ]);

        $program = Program::create($request->all());
        return response()->json($program);
    }

    // CRUD Kegiatan
    public function storeKegiatan(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id',
            'kode' => 'required|unique:kegiatan',
            'nama' => 'required'
        ]);

        $kegiatan = Kegiatan::create($request->all());
        return response()->json($kegiatan);
    }

    // CRUD Sub Kegiatan
    public function storeSubKegiatan(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'kode' => 'required|unique:sub_kegiatan',
            'nama' => 'required'
        ]);

        $subKegiatan = SubKegiatan::create($request->all());
        return response()->json($subKegiatan);
    }
} 