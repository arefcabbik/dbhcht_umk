<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BidangUrusan;

class BidangUrusanController extends Controller
{
    public function data()
    {
        $bidangUrusans = BidangUrusan::with('urusan')->get();
        return response()->json($bidangUrusans);
    }

    public function list(Request $request)
    {
        $query = BidangUrusan::where('aktif', '1');
        
        if ($request->has('kode_urusan')) {
            $query->where('kode_urusan', $request->kode_urusan);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'nama_bidang_urusan' => 'required'
        ]);

        // Generate kode bidang urusan
        $lastBidangUrusan = BidangUrusan::where('kode_urusan', $request->kode_urusan)
            ->orderBy('kode', 'desc')
            ->first();

        $newNumber = $lastBidangUrusan ? intval(substr($lastBidangUrusan->kode, -2)) + 1 : 1;
        $kode = $request->kode_urusan . '.' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        BidangUrusan::create([
            'kode' => $kode,
            'kode_urusan' => $request->kode_urusan,
            'nama_bidang_urusan' => $request->nama_bidang_urusan,
            'aktif' => '1'
        ]);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function show($id)
    {
        return BidangUrusan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_urusan' => 'required|exists:urusan,kode',
            'nama_bidang_urusan' => 'required'
        ]);

        $bidangUrusan = BidangUrusan::findOrFail($id);
        $bidangUrusan->update([
            'kode_urusan' => $request->kode_urusan,
            'nama_bidang_urusan' => $request->nama_bidang_urusan
        ]);

        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function destroy($id)
    {
        $bidangUrusan = BidangUrusan::findOrFail($id);
        $bidangUrusan->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
} 