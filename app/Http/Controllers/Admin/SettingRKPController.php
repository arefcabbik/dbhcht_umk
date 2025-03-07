<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodeRKP;
use DataTables;

class SettingRKPController extends Controller
{
    public function index()
    {
        return view('admin.setting.rkp');
    }

    public function data()
    {
        $data = PeriodeRKP::query();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return $row->status ? 'Aktif' : 'Tidak Aktif';
            })
            ->addColumn('status_perubahan', function ($row) {
                return $row->status_perubahan ? 'Dibuka' : 'Ditutup';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-sm btn-warning" onclick="editPeriode('.$row->id.')">
                            <i class="fas fa-edit"></i>
                        </button>';
                $btn .= ' <button type="button" class="btn btn-sm btn-danger" onclick="deletePeriode('.$row->id.')">
                            <i class="fas fa-trash"></i>
                        </button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function list()
    {
        return PeriodeRKP::where('status', true)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2024|max:2030',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);

        // Jika status aktif, nonaktifkan periode lain
        if ($request->status == 1) {
            PeriodeRKP::where('status', true)->update(['status' => false]);
        }

        PeriodeRKP::create([
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Data periode RKP berhasil disimpan']);
    }

    public function show($id)
    {
        return PeriodeRKP::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2024|max:2030',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);

        $periode = PeriodeRKP::findOrFail($id);

        // Jika status aktif, nonaktifkan periode lain
        if ($request->status == 1 && !$periode->status) {
            PeriodeRKP::where('status', true)->update(['status' => false]);
        }

        $periode->update([
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Data periode RKP berhasil diupdate']);
    }

    public function destroy($id)
    {
        $periode = PeriodeRKP::findOrFail($id);
        $periode->delete();

        return response()->json(['message' => 'Data periode RKP berhasil dihapus']);
    }

    public function storePerubahan(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode_rkp,id',
            'tanggal_mulai_perubahan' => 'required|date',
            'tanggal_selesai_perubahan' => 'required|date|after:tanggal_mulai_perubahan'
        ]);

        $periode = PeriodeRKP::findOrFail($request->periode_id);
        $periode->update([
            'status_perubahan' => $request->status_perubahan,
            'tanggal_mulai_perubahan' => $request->tanggal_mulai_perubahan,
            'tanggal_selesai_perubahan' => $request->tanggal_selesai_perubahan
        ]);

        return response()->json(['message' => 'Setting perubahan RKP berhasil disimpan']);
    }
} 