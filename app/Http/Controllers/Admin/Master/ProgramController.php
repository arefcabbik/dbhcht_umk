<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\BidangUrusan;

class ProgramController extends Controller
{
    public function data()
    {
        $programs = Program::with(['urusan', 'bidangUrusan'])->get();
        return response()->json($programs);
    }

    public function list(Request $request)
    {
        $query = Program::where('aktif', '1');
        
        if ($request->has('kode_bidang_urusan')) {
            $query->where('kode_bidang_urusan', $request->kode_bidang_urusan);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'nama_program' => 'required'
        ]);

        // Generate kode program
        $lastProgram = Program::where('kode_bidang_urusan', $request->kode_bidang_urusan)
            ->orderBy('kode', 'desc')
            ->first();

        $newNumber = $lastProgram ? intval(substr($lastProgram->kode, -2)) + 1 : 1;
        $kode = $request->kode_bidang_urusan . '.' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        Program::create([
            'kode' => $kode,
            'kode_urusan' => $request->kode_urusan,
            'kode_bidang_urusan' => $request->kode_bidang_urusan,
            'nama_program' => $request->nama_program,
            'id_periode' => $request->id_periode,
            'aktif' => '1'
        ]);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function show($id)
    {
        return Program::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'kode_bidang_urusan' => 'required|exists:bidang_urusan,kode',
            'nama_program' => 'required'
        ]);

        $program = Program::findOrFail($id);
        $program->update([
            'kode_urusan' => $request->kode_urusan,
            'kode_bidang_urusan' => $request->kode_bidang_urusan,
            'nama_program' => $request->nama_program
        ]);

        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function getBidangUrusan($kodeUrusan)
    {
        $bidangUrusans = BidangUrusan::where('kode_urusan', $kodeUrusan)
            ->where('aktif', '1')
            ->get();
        return response()->json($bidangUrusans);
    }
} 