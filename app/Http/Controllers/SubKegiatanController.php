<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\SubKegiatan;
use App\Models\Kegiatan;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubKegiatanController extends Controller
{
    public function index()
    {
        $periode_aktif = Periode::where('aktif', '1')->first();
        return view('admin.master.sub-kegiatan.index', compact('periode_aktif'));
    }

    public function data()
    {
        $subKegiatan = SubKegiatan::with(['urusan', 'bidangUrusan', 'program', 'kegiatan'])
            ->orderBy('kode', 'asc')
            ->get();
        
        return response()->json($subKegiatan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_urusan' => 'required',
            'kode_bidang_urusan' => 'required',
            'kode_program' => 'required',
            'kode_kegiatan' => 'required',
            'nama_sub_kegiatan' => 'required|string|max:255',
            'id_periode' => 'required|exists:periode,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        try {
            DB::beginTransaction();

            // Generate kode sub kegiatan
            $lastKode = SubKegiatan::where('kode_kegiatan', $request->kode_kegiatan)
                ->orderBy('kode', 'desc')
                ->first();

            $newNumber = $lastKode ? (intval(substr($lastKode->kode, -2)) + 1) : 1;
            $kode = $request->kode_kegiatan . '.' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

            $subKegiatan = SubKegiatan::create([
                'kode' => $kode,
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
                'id_periode' => $request->id_periode,
                'aktif' => $request->has('aktif') ? '1' : '0'
            ]);

            DB::commit();
            return response()->json(['message' => 'Data berhasil disimpan', 'data' => $subKegiatan]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $subKegiatan = SubKegiatan::findOrFail($id);
        return response()->json($subKegiatan);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_urusan' => 'required',
            'kode_bidang_urusan' => 'required',
            'kode_program' => 'required',
            'kode_kegiatan' => 'required',
            'nama_sub_kegiatan' => 'required|string|max:255',
            'id_periode' => 'required|exists:periode,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        try {
            DB::beginTransaction();

            $subKegiatan = SubKegiatan::findOrFail($id);
            $subKegiatan->update([
                'kode_urusan' => $request->kode_urusan,
                'kode_bidang_urusan' => $request->kode_bidang_urusan,
                'kode_program' => $request->kode_program,
                'kode_kegiatan' => $request->kode_kegiatan,
                'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
                'id_periode' => $request->id_periode,
                'aktif' => $request->has('aktif') ? '1' : '0'
            ]);

            DB::commit();
            return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $subKegiatan]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
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
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function getKegiatan($kodeProgram)
    {
        $kegiatan = Kegiatan::where('kode_program', $kodeProgram)
            ->where('aktif', '1')
            ->orderBy('kode', 'asc')
            ->get();
        
        return response()->json($kegiatan);
    }
} 