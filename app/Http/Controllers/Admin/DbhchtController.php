<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dbhcht;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DbhchtController extends Controller
{
    public function index()
    {
        return view('admin.master.dbhcht.index');
    }

    public function list()
    {
        $data = Dbhcht::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('program', function ($row) {
                $programs = [
                    'peningkatan_kualitas' => 'Peningkatan Kualitas Bahan Baku',
                    'pembinaan_industri' => 'Pembinaan Industri',
                    'pembinaan_lingkungan' => 'Pembinaan Lingkungan Sosial',
                    'sosialisasi_cukai' => 'Sosialisasi Ketentuan di Bidang Cukai',
                    'pemberantasan_ilegal' => 'Pemberantasan Barang Kena Cukai Ilegal',
                    'kegiatan_lainnya' => 'Kegiatan Lainnya'
                ];
                return $programs[$row->program] ?? $row->program;
            })
            ->addColumn('kegiatan', function ($row) {
                if ($row->program === 'peningkatan_kualitas') {
                    $kegiatan = [
                        'pelatihan' => 'Pelatihan Peningkatan Kualitas Bahan Baku',
                        'penanganan_panen' => 'Penanganan Panen dan Pasca Panen',
                        'inovasi_teknis' => 'Penerapan Inovasi Teknis',
                        'sarana_prasarana' => 'Dukungan Sarana dan Prasarana Usaha Pertanian'
                    ];
                    return $kegiatan[$row->kegiatan] ?? $row->kegiatan;
                }
                return '-';
            })
            ->addColumn('status', function ($row) {
                return $row->status ? '<span class="badge-active">Aktif</span>' : '<span class="badge-inactive">Tidak Aktif</span>';
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<button type="button" class="btn btn-sm btn-warning" onclick="editDbhCht('.$row->id.')"><i class="fas fa-edit"></i></button>';
                $deleteBtn = '<button type="button" class="btn btn-sm btn-danger ms-1" onclick="deleteDbhCht('.$row->id.')"><i class="fas fa-trash"></i></button>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'program' => 'required',
            'kegiatan_peningkatan' => 'required_if:program,peningkatan_kualitas',
            'keterangan' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $dbhcht = new Dbhcht();
            $dbhcht->kode = $this->generateKode();
            $dbhcht->program = $request->program;
            $dbhcht->kegiatan = $request->program === 'peningkatan_kualitas' ? $request->kegiatan_peningkatan : null;
            $dbhcht->keterangan = $request->keterangan;
            $dbhcht->status = true;
            $dbhcht->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data DBH CHT berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $dbhcht = Dbhcht::findOrFail($id);
        return response()->json($dbhcht);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program' => 'required',
            'kegiatan_peningkatan' => 'required_if:program,peningkatan_kualitas',
            'keterangan' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $dbhcht = Dbhcht::findOrFail($id);
            $dbhcht->program = $request->program;
            $dbhcht->kegiatan = $request->program === 'peningkatan_kualitas' ? $request->kegiatan_peningkatan : null;
            $dbhcht->keterangan = $request->keterangan;
            $dbhcht->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data DBH CHT berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $dbhcht = Dbhcht::findOrFail($id);
            $dbhcht->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data DBH CHT berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateKode()
    {
        $lastKode = Dbhcht::orderBy('kode', 'desc')->first();
        if (!$lastKode) {
            return 'DBHCHT001';
        }

        $lastNumber = intval(substr($lastKode->kode, -3));
        $newNumber = $lastNumber + 1;
        return 'DBHCHT' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
} 