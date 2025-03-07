<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\SubKegiatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubKegiatanController extends Controller
{
    public function data()
    {
        $subKegiatan = SubKegiatan::with(['kegiatan'])->get();
        return response()->json($subKegiatan);
    }

    public function list(Request $request)
    {
        $query = SubKegiatan::where('aktif', '1');
        
        if ($request->has('kode_kegiatan')) {
            $query->where('kode_kegiatan', $request->kode_kegiatan);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required',
            'kode_bidang_urusan' => 'required',
            'kode_program' => 'required',
            'kode_kegiatan' => 'required',
            'nama_sub_kegiatan' => 'required',
            'id_periode' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Generate kode sub kegiatan
            $lastKode = SubKegiatan::where('kode_kegiatan', $request->kode_kegiatan)
                ->orderBy('kode', 'desc')
                ->first();

            $newNumber = $lastKode ? intval(substr($lastKode->kode, -2)) + 1 : 1;
            $kode = $request->kode_kegiatan . sprintf('%02d', $newNumber);

            $subKegiatan = SubKegiatan::create([
                'kode' => $kode,
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'id_periode' => $request->id_periode,
                'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
                'aktif' => $request->aktif ?? '1'
            ]);

            DB::commit();
            return response()->json($subKegiatan);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $subKegiatan = SubKegiatan::findOrFail($id);
        return response()->json($subKegiatan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_urusan' => 'required',
            'kode_bidang_urusan' => 'required',
            'kode_program' => 'required',
            'kode_kegiatan' => 'required',
            'nama_sub_kegiatan' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $subKegiatan = SubKegiatan::findOrFail($id);
            $subKegiatan->update([
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
                'aktif' => $request->aktif ?? '0'
            ]);

            DB::commit();
            return response()->json($subKegiatan);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $subKegiatan = SubKegiatan::findOrFail($id);
            $subKegiatan->delete();

            DB::commit();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getKegiatan($kodeProgram)
    {
        $kegiatan = Kegiatan::where('kode_program', $kodeProgram)
            ->where('aktif', '1')
            ->get();
        return response()->json($kegiatan);
    }
} 