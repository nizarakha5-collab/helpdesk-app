<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSettingsController extends Controller
{
    public function index()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('auth');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('auth');
        }

        $mustCreatePassword = $user->auth_provider === 'google' && !$user->password_initialized_at;

        return view('user.settings', [
            'user' => $user,
            'mustCreatePassword' => $mustCreatePassword,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('auth');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('auth');
        }

        $mustCreatePassword = $user->auth_provider === 'google' && !$user->password_initialized_at;

        if ($mustCreatePassword) {
            $validated = $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ], [
                'password.required' => 'Le nouveau mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            ]);

            $user->update([
                'password' => Hash::make($validated['password']),
                'password_initialized_at' => now(),
            ]);

            return back()->with('success', 'Mot de passe créé avec succès.');
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password']),
            'password_initialized_at' => $user->password_initialized_at ?? now(),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
}