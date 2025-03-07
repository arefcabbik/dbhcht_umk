<?php

namespace App\Http\Controllers;

use App\Models\Ssh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SshController extends Controller
{
    public function index()
    {
        return view('opd.ssh.index');
    }

    public function data()
    {
        try {
            // Debug: Cek jumlah data
            $count = DB::table('ssh')->count();
            Log::info("Jumlah data SSH: " . $count);

            // Debug: Tampilkan beberapa data pertama
            $sample = DB::table('ssh')->limit(3)->get();
            Log::info("Sample data SSH: " . json_encode($sample));

            $ssh = DB::table('ssh');

            return DataTables::of($ssh)
                ->addIndexColumn()
                ->editColumn('uraian_kelompok_barang', function($row) {
                    return $row->uraian_kelompok_barang ?? 'Bahan Bangunan dan Konstruksi';
                })
                ->editColumn('spesifikasi', function($row) {
                    return $row->spesifikasi ?? '-';
                })
                ->editColumn('satuan', function($row) {
                    return $row->satuan ?? 'Buah';
                })
                ->editColumn('harga_satuan', function($row) {
                    return $row->harga_satuan ?? 0;
                })
                ->editColumn('kode_rekening', function($row) {
                    return $row->kode_rekening ?? '-';
                })
                ->make(true);
        } catch (\Exception $e) {
            Log::error("Error in SSH data: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {
        // Fungsi untuk import data SSH (bisa ditambahkan nanti)
    }

    public function export()
    {
        // Fungsi untuk export data SSH (bisa ditambahkan nanti)
    }

    public function storeCustom(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string',
            'spesifikasi' => 'required|string',
            'satuan' => 'required|string',
            'harga' => 'required|numeric'
        ]);

        Ssh::create([
            'kode' => 'CST' . time(),
            'nama_item' => $request->nama_item,
            'spesifikasi' => $request->spesifikasi,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'is_custom' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data SSH berhasil ditambahkan'
        ]);
    }
} 