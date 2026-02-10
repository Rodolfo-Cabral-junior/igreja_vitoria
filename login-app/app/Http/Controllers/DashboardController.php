<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * Display dashboard with users list
     */
    public function index()
    {
        // Obter usuários do banco de dados
        $users = User::all();
        
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show form to create new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Verificar unicidade case insensitive para username
        $existingUsername = User::whereRaw('UPPER(username) = ?', [strtoupper($request->username)])
            ->first();
        
        if ($existingUsername) {
            return back()->withErrors(['username' => 'Este nome de usuário já está em uso.'])
                ->withInput();
        }

        // Criar usuário no banco de dados
        User::create([
            'name' => strtoupper($request->name),
            'email' => strtolower($request->email), // Email sempre em minúsculas
            'username' => strtoupper($request->username),
            'role' => $request->role,
            'password' => Hash::make(strtoupper($request->password)),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Show form to edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Verificar unicidade case insensitive para username
        $existingUsername = User::where('id', '!=', $id)
            ->whereRaw('UPPER(username) = ?', [strtoupper($request->username)])
            ->first();
        
        if ($existingUsername) {
            return back()->withErrors(['username' => 'Este nome de usuário já está em uso.'])
                ->withInput();
        }

        $user = User::findOrFail($id);
        
        $updateData = [
            'name' => strtoupper($request->name),
            'email' => strtolower($request->email), // Email sempre em minúsculas
            'username' => strtoupper($request->username),
            'role' => $request->role,
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make(strtoupper($request->password));
        }

        $user->update($updateData);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        // Prevent self-deletion
        if (session('user')->id == $id) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Você não pode excluir seu próprio usuário!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }
}
