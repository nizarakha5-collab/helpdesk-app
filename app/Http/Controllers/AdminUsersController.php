<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    private function ensureAdmin()
    {
        if (!session('is_logged_in') || session('role') !== 'admin') {
            abort(403);
        }
    }


    public function index()
    {
        $this->ensureAdmin();

        return view('admin.create-accounts');
    }

    public function storeAdmin(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Username obligatoire.',
            'email.required' => 'Email obligatoire.',
            'email.email' => 'Email invalide.',
            'email.unique' => 'Cet email existe déjà.',
            'password.required' => 'Mot de passe obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'status' => 'active',
            'verification_code' => null,
            'code_expires_at' => null,
        ]);

        return back()->with('success', 'Compte Admin créé avec succès.');
    }

    public function storeAgent(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Username obligatoire.',
            'email.required' => 'Email obligatoire.',
            'email.email' => 'Email invalide.',
            'email.unique' => 'Cet email existe déjà.',
            'password.required' => 'Mot de passe obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'agent',
            'status' => 'active',
            'verification_code' => null,
            'code_expires_at' => null,
        ]);

        return back()->with('success', 'Compte Agent créé avec succès.');
    }

    // Page list des comptes: admin + agent + user
    public function accountsList()
    {
        $this->ensureAdmin();

        $accounts = User::orderBy('id', 'desc')->get();

        return view('admin.accounts-list', compact('accounts'));
    }
    public function delete($id)
{
    $this->ensureAdmin();

    $account = User::findOrFail($id);

    if ($account->id == session('user_id')) {
        return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
    }

    $account->delete();

    return back()->with('success', 'Compte supprimé avec succès.');
}
}
