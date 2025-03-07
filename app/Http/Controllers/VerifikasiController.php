<?php

namespace App\Http\Controllers;

use App\Models\Rkp;
use App\Models\Pd;
use App\Models\Rka;
use App\Models\Opd;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function rkpIndex(Request $request)
    {
        $query = Rkp::with(['pd', 'realisasi']);

        if ($request->pd_id) {
            $query->where('pd_id', $request->pd_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $rkp = $query->get();
        $pd = Pd::all();

        return view('admin.verifikasirkp', compact('rkp', 'pd'));
    }

    public function rkpApprove(Rkp $rkp)
    {
        $rkp->update([
            'status' => 'selesai',
            'is_approved_perekonomian' => true
        ]);

        return response()->json(['message' => 'RKP berhasil diverifikasi']);
    }

    public function rkpRevisi(Request $request, Rkp $rkp)
    {
        $request->validate([
            'catatan_revisi' => 'required'
        ]);

        $rkp->update([
            'status' => 'revisi',
            'catatan_revisi' => $request->catatan_revisi
        ]);

        return redirect()->route('admin.verifikasi.rkp')
            ->with('success', 'RKP dikembalikan untuk revisi');
    }

    public function rkaIndex(Request $request)
    {
        $query = Rka::with(['pd', 'urusan', 'bidangUrusan', 'program', 'kegiatan', 'subKegiatan']);

        // Filter OPD
        if ($request->pd_id) {
            $query->where('pd_id', $request->pd_id);
        }

        // Filter Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $rka = $query->get();
        $pd = Pd::all();

        return view('admin.verifikasirka', compact('rka', 'pd'));
    }

    public function rkaApprove($id)
    {
        try {
            $rka = Rka::findOrFail($id);
            $rka->update(['status' => 'approved']);

            return response()->json([
                'success' => true,
                'message' => 'RKA berhasil disetujui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rkaRevisi(Request $request, $id)
    {
        try {
            $rka = Rka::findOrFail($id);
            $rka->update([
                'status' => 'revisi',
                'catatan_revisi' => $request->catatan_revisi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'RKA berhasil direvisi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
} 