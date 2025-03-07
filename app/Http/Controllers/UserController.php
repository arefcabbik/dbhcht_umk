<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('pd')->get();
        $pd = Pd::all();
        return view('admin.manajemenpengguna', compact('users', 'pd'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'level' => 'required|in:admin,opd',
            'nama_dinas' => 'required_if:level,opd',
            'singkatan' => 'required_if:level,opd',
            'alamat' => 'required_if:level,opd',
            'telepon' => 'required_if:level,opd'
        ]);

        try {
            DB::beginTransaction();

            // Jika level OPD, buat data PD dulu
            $pdId = null;
            if ($request->level === 'opd') {
                $pd = Pd::create([
                    'nama_dinas' => $request->nama_dinas,
                    'singkatan' => $request->singkatan,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon
                ]);
                $pdId = $pd->id;
            }

            // Buat user
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
                'id_pd' => $pdId,
                'aktif' => $request->has('aktif')
            ]);

            DB::commit();
            return redirect()->route('admin.manajemenpengguna')
                ->with('success', 'Pengguna berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'level' => 'required|in:admin,opd',
            'nama_dinas' => 'required_if:level,opd',
            'singkatan' => 'required_if:level,opd',
            'alamat' => 'required_if:level,opd',
            'telepon' => 'required_if:level,opd'
        ]);

        try {
            DB::beginTransaction();

            // Update atau buat PD jika level OPD
            $pdId = null;
            if ($request->level === 'opd') {
                if ($user->id_pd) {
                    // Update PD yang ada
                    $pd = Pd::findOrFail($user->id_pd);
                    $pd->update([
                        'nama_dinas' => $request->nama_dinas,
                        'singkatan' => $request->singkatan,
                        'alamat' => $request->alamat,
                        'telepon' => $request->telepon
                    ]);
                    $pdId = $pd->id;
                } else {
                    // Buat PD baru
                    $pd = Pd::create([
                        'nama_dinas' => $request->nama_dinas,
                        'singkatan' => $request->singkatan,
                        'alamat' => $request->alamat,
                        'telepon' => $request->telepon
                    ]);
                    $pdId = $pd->id;
                }
            }

            // Update user
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'level' => $request->level,
                'id_pd' => $pdId,
                'aktif' => $request->has('aktif')
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            DB::commit();
            return redirect()->route('admin.manajemenpengguna')
                ->with('success', 'Pengguna berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data. ' . $e->getMessage()]);
        }
    }

    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            if ($user->id === auth()->id()) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
            }

            // Hapus data terkait PD jika user adalah OPD
            if ($user->level === 'opd' && $user->id_pd) {
                // Hapus RKP terkait
                DB::table('rkp')->where('pd_id', $user->id_pd)->delete();
                
                // Hapus Laporan terkait
                DB::table('laporan')->where('opd_id', $user->id_pd)->delete();
                
                // Hapus RKA terkait
                DB::table('rka')->where('pd_id', $user->id_pd)->delete();
                
                // Hapus PD
                DB::table('pd')->where('id', $user->id_pd)->delete();
            }

            // Hapus user
            $user->delete();

            DB::commit();
            return redirect()->route('admin.manajemenpengguna')
                ->with('success', 'Pengguna berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
} 