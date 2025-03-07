<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\Rka;
use Illuminate\Http\Request;

class RkaController extends Controller
{
    public function manual()
    {
        $programs = Program::where('aktif', 1)->get();
        return view('opd.rka.manual', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'kegiatan_id' => 'required',
            'sub_kegiatan_id' => 'required',
            'sumber_dana' => 'required',
            'nilai_anggaran' => 'required|numeric',
            'rincian' => 'required|array',
            'rincian.*.komponen' => 'required',
            'rincian.*.item' => 'required',
            'rincian.*.nilai' => 'required|numeric'
        ]);

        // Simpan RKA
        $rka = Rka::create([
            'program_id' => $request->program_id,
            'kegiatan_id' => $request->kegiatan_id,
            'sub_kegiatan_id' => $request->sub_kegiatan_id,
            'sumber_dana' => $request->sumber_dana,
            'nilai_anggaran' => $request->nilai_anggaran,
            'keterangan' => $request->keterangan,
            'opd_id' => auth()->user()->opd_id,
            'status' => 'draft'
        ]);

        // Simpan rincian
        foreach ($request->rincian as $rincian) {
            $rka->rincian()->create([
                'komponen' => $rincian['komponen'],
                'item' => $rincian['item'],
                'nilai' => $rincian['nilai']
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getKegiatan($program_id)
    {
        $kegiatan = Kegiatan::where('program_id', $program_id)
            ->where('aktif', 1)
            ->get();
        return response()->json($kegiatan);
    }

    public function getSubKegiatan($kegiatan_id)
    {
        $subKegiatan = SubKegiatan::where('kegiatan_id', $kegiatan_id)
            ->where('aktif', 1)
            ->get();
        return response()->json($subKegiatan);
    }
} 