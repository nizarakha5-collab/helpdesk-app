<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email obligatoire.',
            'email.email' => 'Email invalide.',
            'password.required' => 'Mot de passe obligatoire.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Aucun compte trouvé avec cet e-mail.',
            ]);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'login' => 'Mot de passe incorrect.',
            ]);
        }

        if ($user->role !== 'admin') {
            if ($user->status === 'pending_email') {
                session(['verify_email' => $user->email]);

                return redirect()->route('verify.code.form')->withErrors([
                    'code' => 'Vérifiez d’abord votre adresse e-mail.',
                ]);
            }

            if ($user->status === 'pending_admin') {
                return back()->withErrors([
                    'login' => 'Votre compte est en attente de validation par l’administrateur.',
                ]);
            }

            if ($user->status === 'rejected') {
                return back()->withErrors([
                    'login' => 'Votre compte a été refusé par l’administrateur.',
                ]);
            }

            if ($user->status !== 'active') {
                return back()->withErrors([
                    'login' => 'Impossible de se connecter avec ce compte.',
                ]);
            }
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

    public function dashboard()
    {
        if (!session('is_logged_in') || session('role') !== 'user') {
            return redirect()->route('auth')->withErrors([
                'login' => 'Accès refusé. Connectez-vous avec un compte user.',
            ]);
        }

        $user = User::findOrFail(session('user_id'));

        $openTickets = Ticket::where('user_id', $user->id)
            ->where('status', 'open')
            ->count();

        $pendingTickets = Ticket::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $resolvedTickets = Ticket::where('user_id', $user->id)
            ->where('status', 'resolved')
            ->count();

        return view('user.dashboard', compact(
            'user',
            'openTickets',
            'pendingTickets',
            'resolvedTickets'
        ));
    }
}