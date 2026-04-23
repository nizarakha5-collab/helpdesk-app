<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email'    => 'required|string|email|max:150|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'username.required' => 'Username obligatoire.',
            'email.required'    => 'Email obligatoire.',
            'email.email'       => 'Email invalide.',
            'email.unique'      => ' email déjà kayn.',
            'password.required' => 'Password obligatoire.',
            'password.min'      => 'Password khaso ykoun plus 8 caractères .',
        ]);

        $verificationCode = (string) random_int(100000, 999999);

        $user = User::create([
    'username'               => $validated['username'],
    'email'                  => $validated['email'],
    'password'               => Hash::make($validated['password']),
    'status'                 => 'pending_email',
    'verification_code'      => $verificationCode,
    'code_expires_at'        => now()->addMinutes(10),
    'auth_provider'          => 'local',
    'password_initialized_at'=> now(),
]);

        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        session(['verify_email' => $user->email]);

        return redirect()->route('verify.code.form');
    }
}