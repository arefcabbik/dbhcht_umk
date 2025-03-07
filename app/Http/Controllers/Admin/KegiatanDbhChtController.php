<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanDbhCht;
use App\Models\ProgramDbhCht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KegiatanDbhChtController extends Controller
{
    public function index()
    {
        $program = ProgramDbhCht::with('bidang')
            ->where('status', true)
            ->get();
        return view('admin.master.dbhcht.kegiatan.index', compact('program'));
    }

    public function list()
    {
        $data = KegiatanDbhCht::with('program.bidang');

        return DataTables::of($data)
            ->addColumn('nama_program', function ($row) {
                return $row->program->nama_program;
            })
            ->addColumn('nama_bidang', function ($row) {
                return $row->program->bidang->nama_bidang;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<button onclick="editData(' . $row->id . ')" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>';
                $deleteBtn = '<button onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'program_id' => 'required|exists:program_dbh_cht,id',
                'nama_kegiatan' => 'required|string|max:255',
                'kode_kegiatan' => 'required|string|max:50|unique:kegiatan_dbh_cht,kode_kegiatan',
                'persentase_alokasi' => 'required|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
            ]);

            KegiatanDbhCht::create([
                'program_id' => $request->program_id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_kegiatan' => $request->kode_kegiatan,
                'persentase_alokasi' => $request->persentase_alokasi,
                'keterangan' => $request->keterangan,
                'status' => true,
            ]);

            DB::commit();
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $kegiatan = KegiatanDbhCht::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $kegiatan = KegiatanDbhCht::findOrFail($id);

            $request->validate([
                'program_id' => 'required|exists:program_dbh_cht,id',
                'nama_kegiatan' => 'required|string|max:255',
                'kode_kegiatan' => 'required|string|max:50|unique:kegiatan_dbh_cht,kode_kegiatan,' . $id,
                'persentase_alokasi' => 'required|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
            ]);

            $kegiatan->update([
                'program_id' => $request->program_id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_kegiatan' => $request->kode_kegiatan,
                'persentase_alokasi' => $request->persentase_alokasi,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return response()->json(['message' => 'Data berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $kegiatan = KegiatanDbhCht::findOrFail($id);
            $kegiatan->delete();

            DB::commit();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function getByProgram($program_id)
    {
        $kegiatan = KegiatanDbhCht::where('program_id', $program_id)
            ->where('status', true)
            ->get();
        return response()->json($kegiatan);
    }
} 