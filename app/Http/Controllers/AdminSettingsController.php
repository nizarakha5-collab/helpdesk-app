<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    protected function currentAdmin()
    {
        if (!session('is_logged_in') || session('role') !== 'admin') {
            return redirect()->route('auth')->send();
        }

        $admin = User::find(session('user_id'));

        if (!$admin) {
            return redirect()->route('auth')->send();
        }

        return $admin;
    }

    public function show()
    {
        $admin = $this->currentAdmin();

        return view('admin.settings', compact('admin'));
    }

    public function updatePassword(Request $request)
    {
        $admin = $this->currentAdmin();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (!Hash::check($validated['current_password'], $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ])->withInput();
        }

        $admin->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
}