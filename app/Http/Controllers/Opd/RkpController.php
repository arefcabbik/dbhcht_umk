<?php

namespace App\Http\Controllers\Opd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rkp;

class RkpController extends Controller
{
    public function input()
    {
        $rkp_data = Rkp::where('pd_id', auth()->user()->id_pd)
            ->with(['program', 'kegiatan'])
            ->get();
        return view('opd.rkp.input', compact('rkp_data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_program' => 'required|exists:program,kode',
            'kode_kegiatan' => 'required|exists:kegiatan,kode',
            'indikator' => 'required|string',
            'target' => 'required|numeric',
            'satuan' => 'required|string',
            'pagu_anggaran' => 'required|numeric'
        ]);

        $rkp = Rkp::create([
            'pd_id' => auth()->user()->id_pd,
            'kode_program' => $validated['kode_program'],
            'kode_kegiatan' => $validated['kode_kegiatan'],
            'indikator' => $validated['indikator'],
            'target' => $validated['target'],
            'satuan' => $validated['satuan'],
            'pagu_anggaran' => $validated['pagu_anggaran'],
            'status' => 'draft'
        ]);

        return redirect()->route('opd.rkp.input')
            ->with('success', 'Data RKP berhasil disimpan');
    }

    public function perubahan()
    {
        return view('opd.rkp.perubahan');
    }

    public function history()
    {
        $history = Rkp::where('pd_id', auth()->user()->id_pd)
            ->where('status', 'perubahan')
            ->with(['program', 'kegiatan'])
            ->orderBy('updated_at', 'desc')
            ->get();
            
        return view('opd.rkp.history', compact('history'));
    }
} 