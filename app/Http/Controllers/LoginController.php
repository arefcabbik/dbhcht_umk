<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnLevel();
        }
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Cek user aktif
        $user = User::where('username', $request->username)
                   ->where('aktif', '1')
                   ->first();

        if ($user && Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnLevel();
        }

        return back()->withErrors([
            'username' => 'Username atau password yang dimasukkan tidak sesuai.',
        ])->onlyInput('username');
    }

    protected function redirectBasedOnLevel()
    {
        if (Auth::user()->level === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('opd.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
} 