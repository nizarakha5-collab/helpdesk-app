<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentSettingsController extends Controller
{
    protected function currentAgent()
    {
        if (!session('is_logged_in') || session('role') !== 'agent') {
            return redirect()->route('auth')->send();
        }

        $agent = User::find(session('user_id'));

        if (!$agent) {
            return redirect()->route('auth')->send();
        }

        return $agent;
    }

    public function show()
    {
        $agent = $this->currentAgent();

        return view('agent.settings', compact('agent'));
    }

    public function updatePassword(Request $request)
    {
        $agent = $this->currentAgent();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (!Hash::check($validated['current_password'], $agent->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ])->withInput();
        }

        $agent->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
}