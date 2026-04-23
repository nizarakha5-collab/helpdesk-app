<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
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

        $accounts = User::whereIn('role', ['admin', 'agent'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.accounts', compact('accounts'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,agent'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active'
        ]);

        return redirect()->route('admin.accounts')
            ->with('success', 'Account created successfully');
    }

    public function delete($id)
    {
        $this->ensureAdmin();

        User::where('id', $id)
            ->whereIn('role', ['admin', 'agent'])
            ->delete();

        return back()->with('success', 'Account deleted');
    }

    public function updateRole($id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            $user->role = 'agent';
        } else {
            $user->role = 'admin';
        }

        $user->save();

        return back()->with('success', 'Role updated');
    }
}