<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin()
    {
        return view('login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            // Regenerasi session keamanan login
            $request->session()->regenerate();
            $user = auth()->user();

            // 🔐 1. AUDIT LOG: LOGIN BERHASIL
            ActivityLog::record(
                'LOGIN_SUCCESS',
                "User [{$user->name}] berhasil login sebagai " . strtoupper($user->role ?? 'USER')
            );

            return redirect('/admin');
        }

        // 🚨 2. AUDIT LOG: PERCOBAAN LOGIN GAGAL (Salah Username/Password)
        $attemptedUser = $request->input('email');
        ActivityLog::record(
            'LOGIN_FAILED',
            "Percobaan login GAGAL dengan email: [{$attemptedUser}] (Salah Kredensial)",
            $attemptedUser,
            'guest'
        );

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Kredensial yang dimasukkan tidak cocok dengan data kami.',
        ])->withInput($request->only('email'));
    }

    // Memproses logout
    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            // 🔓 3. AUDIT LOG: LOGOUT
            ActivityLog::record(
                'LOGOUT',
                "User [{$user->name}] keluar dari sistem"
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Setelah logout kembali ke beranda
    }
}