<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgentProfileController extends Controller
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

        return view('agent.profile', compact('agent'));
    }

    public function update(Request $request)
    {
        $agent = $this->currentAgent();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $agent->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'speciality' => ['nullable', 'string', 'max:255'],
            'cin' => ['nullable', 'string', 'max:30'],
            'cne' => ['nullable', 'string', 'max:30'],
            'date_naissance' => ['nullable', 'date'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'username.required' => 'Le nom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'Email invalide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.mimes' => 'Formats acceptés : jpg, jpeg, png, webp.',
            'avatar.max' => 'La taille de l’image ne doit pas dépasser 2 Mo.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($agent->avatar_path && Storage::disk('public')->exists($agent->avatar_path)) {
                Storage::disk('public')->delete($agent->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $agent->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'speciality' => $validated['speciality'] ?? null,
            'cin' => $validated['cin'] ?? null,
            'cne' => $validated['cne'] ?? null,
            'date_naissance' => $validated['date_naissance'] ?? null,
            'avatar_path' => $validated['avatar_path'] ?? $agent->avatar_path,
        ]);

        session([
            'user_name' => $agent->username,
            'user_email' => $agent->email,
        ]);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}