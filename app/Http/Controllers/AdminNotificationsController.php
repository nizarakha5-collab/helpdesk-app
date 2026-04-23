<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;

class AdminNotificationsController extends Controller
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

    public function index()
    {
        $admin = $this->currentAdmin();

        $notifications = UserNotification::with(['relatedUser'])
            ->where('user_id', $admin->id)
            ->latest()
            ->paginate(10);

        $unreadCount = UserNotification::where('user_id', $admin->id)
            ->where('is_read', false)
            ->count();

        return view('admin.notifications', compact('admin', 'notifications', 'unreadCount'));
    }

    public function markAsRead(UserNotification $notification)
    {
        $admin = $this->currentAdmin();

        if ((int) $notification->user_id !== (int) $admin->id) {
            abort(403);
        }

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        $admin = $this->currentAdmin();

        UserNotification::where('user_id', $admin->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}