<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        if ($request->user()->role === 'admin') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Login untuk admin tidak diizinkan di halaman ini.',
            ]);
        }

        session()->flash('success', "Berhasil masuk aplikasi");
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('success', 'Berhasil keluar aplikasi');
        return redirect('/login');
    }
}
