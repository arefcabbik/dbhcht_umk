<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\PeriodeRKP;

class SettingController extends Controller
{
    public function rkpIndex()
    {
        $periodes = Periode::all();
        $periodeRKPs = PeriodeRKP::with('periode')->get();
        return view('admin.setting.rkp.index', compact('periodes', 'periodeRKPs'));
    }

    public function rkpStore(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        PeriodeRKP::create($request->all());
        return redirect()->route('admin.setting.rkp.index')->with('success', 'Periode RKP berhasil ditambahkan');
    }

    public function rkpUpdate(Request $request, $id)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $periodeRKP = PeriodeRKP::findOrFail($id);
        $periodeRKP->update($request->all());
        return redirect()->route('admin.setting.rkp.index')->with('success', 'Periode RKP berhasil diupdate');
    }

    public function rkpDestroy($id)
    {
        $periodeRKP = PeriodeRKP::findOrFail($id);
        $periodeRKP->delete();
        return redirect()->route('admin.setting.rkp.index')->with('success', 'Periode RKP berhasil dihapus');
    }
} 