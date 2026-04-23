<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email obligatoire.',
            'email.email' => 'Email invalide.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Aucun compte trouvé avec cette adresse e-mail.',
            ])->withInput();
        }

        $code = (string) random_int(100000, 999999);

        $user->update([
            'reset_password_code' => $code,
            'reset_password_expires_at' => now()->addMinutes(10),
        ]);

        Mail::raw(
            "Bonjour {$user->username},\n\nVotre code de réinitialisation est : {$code}\n\nCe code expire dans 10 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Code de réinitialisation du mot de passe');
            }
        );

        session([
            'reset_password_email' => $user->email,
            'reset_password_verified' => false,
        ]);

        return redirect()
            ->route('password.code.form')
            ->with('success', 'Un code de réinitialisation a été envoyé à votre adresse e-mail.');
    }

    public function showCodeForm()
    {
        if (!session('reset_password_email')) {
            return redirect()->route('password.forgot.form')->withErrors([
                'email' => 'Commencez d’abord par entrer votre adresse e-mail.',
            ]);
        }

        return view('auth.verify-reset-code', [
            'email' => session('reset_password_email'),
        ]);
    }

    public function verifyCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ], [
            'email.required' => 'Email obligatoire.',
            'email.email' => 'Email invalide.',
            'code.required' => 'Code obligatoire.',
            'code.size' => 'Le code doit contenir 6 chiffres.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Aucun compte trouvé avec cette adresse e-mail.',
            ])->withInput();
        }

        if ($user->reset_password_code !== $validated['code']) {
            return back()->withErrors([
                'code' => 'Code incorrect.',
            ])->withInput();
        }

        if ($user->reset_password_expires_at && now()->greaterThan($user->reset_password_expires_at)) {
            return back()->withErrors([
                'code' => 'Code expiré.',
            ])->withInput();
        }

        session([
            'reset_password_email' => $user->email,
            'reset_password_verified' => true,
        ]);

        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        if (!session('reset_password_email') || !session('reset_password_verified')) {
            return redirect()->route('password.forgot.form')->withErrors([
                'email' => 'Vous devez d’abord vérifier votre code.',
            ]);
        }

        return view('auth.reset-password', [
            'email' => session('reset_password_email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        if (!session('reset_password_email') || !session('reset_password_verified')) {
            return redirect()->route('password.forgot.form')->withErrors([
                'email' => 'Vous devez d’abord vérifier votre code.',
            ]);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user = User::where('email', session('reset_password_email'))->first();

        if (!$user) {
            return redirect()->route('password.forgot.form')->withErrors([
                'email' => 'Aucun compte trouvé.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
            'reset_password_code' => null,
            'reset_password_expires_at' => null,
        ]);

        session()->forget([
            'reset_password_email',
            'reset_password_verified',
        ]);

        return view('auth.reset-password-success');
    }
}