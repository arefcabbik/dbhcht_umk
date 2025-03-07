<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanIndikator;
use App\Models\Kegiatan;

class KegiatanIndikatorController extends Controller
{
    public function data()
    {
        $kegiatanIndikator = KegiatanIndikator::with(['kegiatan'])->get();
        return response()->json($kegiatanIndikator);
    }

    public function list(Request $request)
    {
        $query = KegiatanIndikator::where('aktif', '1');
        
        if ($request->has('kode_kegiatan')) {
            $query->where('kode_kegiatan', $request->kode_kegiatan);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'kode_kegiatan' => 'required|exists:kegiatan,kode',
            'indikator' => 'required'
        ]);

        // Generate kode indikator
        $lastIndikator = KegiatanIndikator::where('kode_kegiatan', $request->kode_kegiatan)
            ->orderBy('kode', 'desc')
            ->first();

        $newNumber = $lastIndikator ? intval(substr($lastIndikator->kode, -2)) + 1 : 1;
        $kode = $request->kode_kegiatan . '.' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        KegiatanIndikator::create([
            'kode' => $kode,
            'kode_urusan' => $request->kode_urusan,
            'kode_bidang_urusan' => $request->kode_bidang_urusan,
            'kode_program' => $request->kode_program,
            'kode_kegiatan' => $request->kode_kegiatan,
            'indikator' => $request->indikator,
            'id_periode' => $request->id_periode,
            'aktif' => '1'
        ]);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function show($id)
    {
        return KegiatanIndikator::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'kode_kegiatan' => 'required|exists:kegiatan,kode',
            'indikator' => 'required'
        ]);

        $kegiatanIndikator = KegiatanIndikator::findOrFail($id);
        $kegiatanIndikator->update([
            'kode_urusan' => $request->kode_urusan,
            'kode_bidang_urusan' => $request->kode_bidang_urusan,
            'kode_program' => $request->kode_program,
            'kode_kegiatan' => $request->kode_kegiatan,
            'indikator' => $request->indikator
        ]);

        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $kegiatanIndikator = KegiatanIndikator::findOrFail($id);
        $kegiatanIndikator->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
} 