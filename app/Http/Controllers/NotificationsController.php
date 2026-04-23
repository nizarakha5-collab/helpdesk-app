<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('auth');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('auth');
        }

        $notifications = UserNotification::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $unreadCount = UserNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('user.notifications', [
            'user' => $user,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markAsRead(UserNotification $notification)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('auth');
        }

        if ((int) $notification->user_id !== (int) $userId) {
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
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('auth');
        }

        UserNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}