<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class VerifyCodeController extends Controller
{
    public function show(Request $request)
    {
        $email = session('verify_email');

        if (!$email) {
            return redirect('/auth')->withErrors([
                'email' => 'Inscrivez-vous d’abord pour vérifier votre compte.',
            ]);
        }

        return view('auth.verify-code', [
            'email' => $email,
            'verified' => false,
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ], [
            'code.required' => 'Code obligatoire.',
            'code.size'     => 'Le code doit contenir 6 chiffres.',
        ]);

        $user = User::where('email', $validated['email'])
            ->where('status', 'pending_email')
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Aucun compte en attente pour cette adresse e-mail.',
            ]);
        }

        if ($user->verification_code !== $validated['code']) {
            return back()->withErrors([
                'code' => 'Code incorrect.',
            ]);
        }

        if ($user->code_expires_at && now()->greaterThan($user->code_expires_at)) {
            return back()->withErrors([
                'code' => 'Code expiré.',
            ]);
        }

        $user->update([
            'status' => 'pending_admin',
            'verification_code' => null,
            'code_expires_at' => null,
        ]);

        $admins = User::where('role', 'admin')
            ->where('status', 'active')
            ->get();

        foreach ($admins as $admin) {
            UserNotification::create([
                'user_id' => $admin->id,
                'type' => 'pending_account',
                'title' => 'Nouveau compte à valider',
                'message' => "Le compte {$user->username} est en attente de validation administrateur.",
                'ticket_id' => null,
                'related_user_id' => $user->id,
                'is_read' => false,
                'read_at' => null,
            ]);
        }

        session(['verify_email' => $user->email]);

        return view('auth.verify-code', [
            'email' => $user->email,
            'verified' => true,
        ]);
    }
}