<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Program;

class KegiatanController extends Controller
{
    public function data()
    {
        $kegiatan = Kegiatan::with(['program'])->get();
        return response()->json($kegiatan);
    }

    public function list(Request $request)
    {
        $query = Kegiatan::where('aktif', '1');
        
        if ($request->has('kode_program')) {
            $query->where('kode_program', $request->kode_program);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'nama_kegiatan' => 'required'
        ]);

        // Generate kode kegiatan
        $lastKegiatan = Kegiatan::where('kode_program', $request->kode_program)
            ->orderBy('kode', 'desc')
            ->first();

        $newNumber = $lastKegiatan ? intval(substr($lastKegiatan->kode, -2)) + 1 : 1;
        $kode = $request->kode_program . '.' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        Kegiatan::create([
            'kode' => $kode,
            'kode_urusan' => $request->kode_urusan,
            'kode_bidang_urusan' => $request->kode_bidang_urusan,
            'kode_program' => $request->kode_program,
            'nama_kegiatan' => $request->nama_kegiatan,
            'id_periode' => $request->id_periode,
            'aktif' => '1'
        ]);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function show($id)
    {
        return Kegiatan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'kode_program' => 'required|exists:program,kode',
            'nama_kegiatan' => 'required'
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update([
            'kode_urusan' => $request->kode_urusan,
            'kode_bidang_urusan' => $request->kode_bidang_urusan,
            'kode_program' => $request->kode_program,
            'nama_kegiatan' => $request->nama_kegiatan
        ]);

        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
} 