<?php

namespace App\Http\Controllers\Opd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ssh;
use Illuminate\Support\Facades\DB;

class SshController extends Controller
{
    public function index()
    {
        $ssh = Ssh::all();
        return view('opd.ssh.index', compact('ssh'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        $ssh = DB::table('ssh')
            ->where('uraian_barang', 'LIKE', "%{$keyword}%")
            ->orWhere('spesifikasi', 'LIKE', "%{$keyword}%")
            ->orWhere('kode_barang', 'LIKE', "%{$keyword}%")
            ->orWhere('kode_kelompok', 'LIKE', "%{$keyword}%")
            ->orWhere('uraian_kelompok', 'LIKE', "%{$keyword}%")
            ->select('id', 'kode_kelompok', 'uraian_kelompok', 'id_standar_harga', 
                    'kode_barang', 'uraian_barang', 'spesifikasi', 'satuan', 
                    'harga_satuan', 'kode_rekening')
            ->get();

        return response()->json($ssh);
    }
} 