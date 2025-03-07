<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDbhCht;
use App\Models\BidangDbhCht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProgramDbhChtController extends Controller
{
    public function index()
    {
        $bidang = BidangDbhCht::where('status', true)->get();
        return view('admin.master.dbhcht.program.index', compact('bidang'));
    }

    public function list()
    {
        $data = ProgramDbhCht::with('bidang');

        return DataTables::of($data)
            ->addColumn('nama_bidang', function ($row) {
                return $row->bidang->nama_bidang;
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
                'bidang_id' => 'required|exists:bidang_dbh_cht,id',
                'nama_program' => 'required|string|max:255',
                'kode_program' => 'required|string|max:50|unique:program_dbh_cht,kode_program',
                'persentase_alokasi' => 'required|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
            ]);

            ProgramDbhCht::create([
                'bidang_id' => $request->bidang_id,
                'nama_program' => $request->nama_program,
                'kode_program' => $request->kode_program,
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
        $program = ProgramDbhCht::findOrFail($id);
        return response()->json($program);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $program = ProgramDbhCht::findOrFail($id);

            $request->validate([
                'bidang_id' => 'required|exists:bidang_dbh_cht,id',
                'nama_program' => 'required|string|max:255',
                'kode_program' => 'required|string|max:50|unique:program_dbh_cht,kode_program,' . $id,
                'persentase_alokasi' => 'required|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
            ]);

            $program->update([
                'bidang_id' => $request->bidang_id,
                'nama_program' => $request->nama_program,
                'kode_program' => $request->kode_program,
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

            $program = ProgramDbhCht::findOrFail($id);
            $program->delete();

            DB::commit();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function getByBidang($bidang_id)
    {
        $programs = ProgramDbhCht::where('bidang_id', $bidang_id)
            ->where('status', true)
            ->get();
        return response()->json($programs);
    }
} 