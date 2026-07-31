<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index () 
    {
        return view('login'); 
    }


    public function auth (LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {

             $request->session()->regenerate();

              return redirect()->route('dashboard')->with('success', 'selamat datang,' . Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid',
        ]); 
    }

        public function logout(Request $request)
    {       // mengakhiri sesi pengguna
            Auth::logout();
            
            // menghapus session pengguna
            $request->session()->invalidate();
            // meregenerasi token CSRF 
            $request->session()->regenerateToken();
            
            // Redirect ke halaman Login setelah Logout
            return redirect()->route('login')->with('success', 'Anda telah keluar aplikasi');
    }
}