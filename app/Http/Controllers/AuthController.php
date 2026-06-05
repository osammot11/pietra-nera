<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostra la pagina di login
    public function showLoginForm()
    {
        // Se è già loggato, lo mandiamo diretto alla dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // Processa i dati del modulo di login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta il login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin'); // Lo manda all'admin
        }

        // Se fallisce, torna indietro con l'errore
        return back()->withErrors([
            'email' => 'Le credenziali inserite non sono corrette.',
        ])->onlyInput('email');
    }

    // Effettua il logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Lo rimanda alla home del sito
    }
}