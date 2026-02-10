<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
            'remember' => 'nullable|string',
        ]);

        $loginUpper = strtoupper($credentials['email']);
        $passwordUpper = strtoupper($credentials['password']);
        
        // Buscar usuário no banco de dados (case insensitive)
        $user = User::where(function($query) use ($loginUpper) {
            $query->whereRaw('UPPER(email) = ?', [$loginUpper])
                  ->orWhereRaw('UPPER(username) = ?', [$loginUpper]);
        })->first();

        if ($user && Hash::check($passwordUpper, $user->password)) {
            session(['user' => $user]);
            
            if (isset($credentials['remember'])) {
                config(['session.lifetime' => 43200]);
            }
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais incorretas. Verifique seu email/username e senha.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }

    public function dashboard()
    {
        if (!session('user')) {
            return redirect('/login');
        }
        
        $user = session('user');
        
        // Se for administrador, redirecionar para dashboard admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Usuário comum vai para dashboard normal
        return view('dashboard');
    }
}
