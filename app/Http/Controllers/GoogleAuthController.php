<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('auth')->withErrors([
                'login' => 'Échec de la connexion avec Google.',
            ]);
        }

        $email = $googleUser->getEmail();
        $name = $googleUser->getName() ?: 'Utilisateur';
        $googleId = $googleUser->getId();
        $avatar = $googleUser->getAvatar();

        if (!$email) {
            return redirect()->route('auth')->withErrors([
                'login' => 'Aucune adresse e-mail n’a été trouvée sur votre compte Google.',
            ]);
        }

        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            $user->update([
                'google_id' => $googleId,
                'avatar' => $avatar,
                'auth_provider' => 'google',
            ]);
        }

        if (!$user) {
            $user = User::create([
                'username' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(24)),
                'google_id' => $googleId,
                'avatar' => $avatar,
                'role' => 'user',
                'status' => 'pending_admin',
                'verification_code' => null,
                'code_expires_at' => null,
                'auth_provider' => 'google',
                'password_initialized_at' => null,
            ]);

            return redirect()->route('auth')->withErrors([
                'login' => 'Compte créé via Google. Il est en attente de validation par l’administrateur.',
            ]);
        }

        if ($user->status === 'pending_admin') {
            return redirect()->route('auth')->withErrors([
                'login' => 'Votre compte est en attente de validation par l’administrateur.',
            ]);
        }

        if ($user->status === 'rejected') {
            return redirect()->route('auth')->withErrors([
                'login' => 'Votre compte a été rejeté par l’administrateur.',
            ]);
        }

        if ($user->status !== 'active') {
            return redirect()->route('auth')->withErrors([
                'login' => 'Impossible de se connecter avec ce compte.',
            ]);
        }

        session([
            'user_id' => $user->id,
            'user_name' => $user->username,
            'user_email' => $user->email,
            'role' => $user->role,
            'is_logged_in' => true,
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'agent') {
            return redirect()->route('agent.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}