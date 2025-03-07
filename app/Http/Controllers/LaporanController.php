<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Rkp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index()
    {
        return view('opd.laporan.bulanan');
    }

    public function data(Request $request)
    {
        $laporan = Laporan::with('kegiatan')
            ->where('opd_id', auth()->user()->opd_id)
            ->where('tahun', $request->tahun)
            ->where('bulan', $request->bulan);

        return DataTables::of($laporan)
            ->addIndexColumn()
            ->addColumn('kegiatan', function ($row) {
                return $row->kegiatan->nama_kegiatan;
            })
            ->addColumn('capaian', function ($row) {
                return number_format(($row->realisasi / $row->target) * 100, 2);
            })
            ->addColumn('capaian_anggaran', function ($row) {
                return number_format(($row->realisasi_anggaran / $row->anggaran) * 100, 2);
            })
            ->addColumn('action', function ($row) {
                return '
                    <button type="button" class="btn btn-sm btn-warning" onclick="editLaporan('.$row->id.')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteLaporan('.$row->id.')">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function kegiatan()
    {
        $kegiatan = Rkp::where('opd_id', auth()->user()->opd_id)
            ->where('status', 'selesai')
            ->get();

        return response()->json($kegiatan);
    }

    public function kegiatanDetail($id)
    {
        $kegiatan = Rkp::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:rkp,id',
            'realisasi' => 'required|numeric',
            'realisasi_anggaran' => 'required|numeric',
            'keterangan' => 'nullable|string'
        ]);

        $kegiatan = Rkp::findOrFail($request->kegiatan_id);

        Laporan::create([
            'opd_id' => auth()->user()->opd_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tahun' => date('Y'),
            'bulan' => date('n'),
            'target' => $kegiatan->target,
            'realisasi' => $request->realisasi,
            'anggaran' => $kegiatan->pagu_anggaran,
            'realisasi_anggaran' => $request->realisasi_anggaran,
            'keterangan' => $request->keterangan
        ]);

        return response()->json(['success' => true]);
    }

    // ... methods lainnya (edit, update, destroy)
} 