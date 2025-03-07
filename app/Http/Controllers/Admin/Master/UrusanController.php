<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Urusan;
use Illuminate\Support\Facades\DB;

class UrusanController extends Controller
{
    public function data()
    {
        try {
            $urusan = Urusan::orderBy('kode', 'asc')->get()->toArray();
            return response()->json($urusan);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        try {
            $urusan = Urusan::where('aktif', '1')
                ->orderBy('kode', 'asc')
                ->get()
                ->toArray();
            return response()->json($urusan);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nama_urusan' => 'required|string|max:255',
            ]);

            // Generate kode urusan (1, 2, 3, dst)
            $lastUrusan = Urusan::orderBy('kode', 'desc')->first();
            $newNumber = $lastUrusan ? intval($lastUrusan->kode) + 1 : 1;
            $kode = str_pad($newNumber, 2, '0', STR_PAD_LEFT);

            $urusan = Urusan::create([
                'kode' => $kode,
                'nama_urusan' => $request->nama_urusan,
                'aktif' => $request->has('aktif') ? '1' : '0'
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $urusan
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $urusan = Urusan::findOrFail($id);
            return response()->json($urusan);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nama_urusan' => 'required|string|max:255',
            ]);

            $urusan = Urusan::findOrFail($id);
            $urusan->update([
                'nama_urusan' => $request->nama_urusan,
                'aktif' => $request->has('aktif') ? '1' : '0'
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $urusan
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $urusan = Urusan::findOrFail($id);
            
            // Check if urusan has related data
            if ($urusan->bidangUrusan()->exists()) {
                throw new \Exception('Tidak dapat menghapus urusan yang memiliki bidang urusan');
            }

            $urusan->delete();
            DB::commit();
            
            return response()->json([
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }
}
