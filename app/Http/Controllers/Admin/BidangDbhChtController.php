<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidangDbhCht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BidangDbhChtController extends Controller
{
    public function index()
    {
        return view('admin.master.dbhcht.bidang.index');
    }

    public function list()
    {
        $data = BidangDbhCht::query();

        return DataTables::of($data)
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
                'nama_bidang' => 'required|string|max:255',
                'kode_bidang' => 'required|string|max:50|unique:bidang_dbh_cht,kode_bidang',
                'persentase_alokasi' => 'required|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
            ]);

            BidangDbhCht::create([
                'nama_bidang' => $request->nama_bidang,
                'kode_bidang' => $request->kode_bidang,
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
        $bidang = BidangDbhCht::findOrFail($id);
        return response()->json($bidang);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $bidang = BidangDbhCht::findOrFail($id);

            $request->validate([
                'nama_bidang' => 'required|string|max:255',
                'kode_bidang' => 'required|string|max:50|unique:bidang_dbh_cht,kode_bidang,' . $id,
                'persentase_alokasi' => 'required|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
            ]);

            $bidang->update([
                'nama_bidang' => $request->nama_bidang,
                'kode_bidang' => $request->kode_bidang,
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

            $bidang = BidangDbhCht::findOrFail($id);
            $bidang->delete();

            DB::commit();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
} 