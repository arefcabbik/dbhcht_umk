<?php

namespace App\Http\Controllers\Opd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rka;
use Illuminate\Support\Facades\Auth;

class RkaController extends Controller
{
    public function data()
    {
        $rka = Rka::with(['urusan', 'bidang_urusan', 'program', 'kegiatan'])
            ->where('opd_id', Auth::user()->opd_id)
            ->get();

        return response()->json($rka);
    }

    public function manual()
    {
        return view('opd.rka.manual');
    }

    public function input()
    {
        $rka_data = Rka::all();
        return view('opd.rka.input', compact('rka_data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'urusan' => 'required',
            'bidang_urusan' => 'required',
            'program' => 'required',
            'kegiatan' => 'required',
            'sub_kegiatan' => 'required',
            'indikator' => 'required',
            'target' => 'required',
            'satuan' => 'required',
            'pagu_anggaran' => 'required|numeric',
        ]);

        $rka = Rka::create($validated);

        return redirect()->route('opd.rka.input')
            ->with('success', 'Data RKA berhasil disimpan');
    }

    public function edit(Rka $rka)
    {
        return view('opd.rka.edit', compact('rka'));
    }

    public function destroy(Rka $rka)
    {
        $rka->delete();
        return redirect()->route('opd.rka.input')
            ->with('success', 'Data RKA berhasil dihapus');
    }
} 