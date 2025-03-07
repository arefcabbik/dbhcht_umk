<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rkp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RkpPerubahan;

class RkpController extends Controller
{
    public function input()
    {
        return view('opd.rkp.input');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'kode_kegiatan' => 'required|exists:kegiatan,kode',
            'indikator' => 'required|string',
            'target' => 'required|numeric',
            'satuan' => 'required|string',
            'pagu_anggaran' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $rkp = Rkp::create([
                'pd_id' => Auth::user()->id_pd,
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'indikator' => $request->indikator,
                'target' => $request->target,
                'satuan' => $request->satuan,
                'pagu_anggaran' => $request->pagu_anggaran,
                'status' => 'draft'
            ]);

            DB::commit();
            return redirect()->route('opd.rkp.input')
                ->with('success', 'Data RKP berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $rkp = Rkp::findOrFail($id);
        return view('opd.rkp.edit', compact('rkp'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'kode_kegiatan' => 'required|exists:kegiatan,kode',
            'indikator' => 'required|string',
            'target' => 'required|numeric',
            'satuan' => 'required|string',
            'pagu_anggaran' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $rkp = Rkp::findOrFail($id);
            $rkp->update([
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'indikator' => $request->indikator,
                'target' => $request->target,
                'satuan' => $request->satuan,
                'pagu_anggaran' => $request->pagu_anggaran
            ]);

            DB::commit();
            return redirect()->route('opd.rkp.input')
                ->with('success', 'Data RKP berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function rekap()
    {
        return view('opd.rkp.rekap');
    }

    public function data()
    {
        $rkp = Rkp::with(['urusan', 'bidangUrusan', 'program', 'kegiatan'])
            ->where('pd_id', Auth::user()->id_pd)
            ->get();
        return response()->json($rkp);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $rkp = Rkp::findOrFail($id);
            
            // Pastikan user hanya bisa menghapus RKP miliknya
            if ($rkp->pd_id !== Auth::user()->id_pd) {
                throw new \Exception('Anda tidak memiliki akses untuk menghapus data ini');
            }
            
            $rkp->delete();
            
            DB::commit();
            return response()->json(['message' => 'Data RKP berhasil dihapus']);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function perubahan()
    {
        return view('opd.rkp.perubahan');
    }

    public function perubahanHistory()
    {
        $perubahan = RkpPerubahan::with(['urusan', 'program', 'kegiatan'])
            ->where('opd_id', Auth::user()->opd_id)
            ->get();
        
        return response()->json($perubahan);
    }

    public function storePerubahan(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'kode_kegiatan' => 'required|exists:kegiatan,kode',
            'indikator' => 'required|string',
            'target' => 'required|numeric',
            'satuan' => 'required|string',
            'pagu_anggaran' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $rkp = Rkp::create([
                'pd_id' => Auth::user()->id_pd,
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'indikator' => $request->indikator,
                'target' => $request->target,
                'satuan' => $request->satuan,
                'pagu_anggaran' => $request->pagu_anggaran,
                'status' => 'draft'
            ]);

            DB::commit();
            return redirect()->route('opd.rkp.perubahan')
                ->with('success', 'Data Perubahan RKP berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
} 