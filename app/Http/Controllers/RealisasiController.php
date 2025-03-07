<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\Realisasi;
use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    public function index()
    {
        $realisasi = Realisasi::with(['program', 'kegiatan', 'subKegiatan'])->get();
        return view('opd.laporan.realisasi.index', compact('realisasi'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('opd.laporan.input_realisasi', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required',
            'kegiatan_id' => 'required',
            'sub_kegiatan_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'realisasi_anggaran' => 'required|numeric',
            'realisasi_fisik' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable'
        ]);

        Realisasi::create($validated);

        return redirect()
            ->route('opd.realisasi.index')
            ->with('success', 'Data realisasi berhasil disimpan');
    }

    public function getKegiatan($programId)
    {
        $kegiatan = Kegiatan::where('program_id', $programId)->get();
        return response()->json($kegiatan);
    }

    public function getSubKegiatan($kegiatanId)
    {
        $subKegiatan = SubKegiatan::where('kegiatan_id', $kegiatanId)->get();
        return response()->json($subKegiatan);
    }

    // Tambahkan method edit, update, dan destroy sesuai kebutuhan
} 