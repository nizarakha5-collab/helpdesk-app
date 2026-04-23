<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;

class AgentNotificationsController extends Controller
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

    public function index()
    {
        $agent = $this->currentAgent();

        $notifications = UserNotification::where('user_id', $agent->id)
            ->latest()
            ->paginate(10);

        $unreadCount = UserNotification::where('user_id', $agent->id)
            ->where('is_read', false)
            ->count();

        return view('agent.notifications', compact('agent', 'notifications', 'unreadCount'));
    }

    public function markAsRead(UserNotification $notification)
    {
        $agent = $this->currentAgent();

        if ((int) $notification->user_id !== (int) $agent->id) {
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
        $agent = $this->currentAgent();

        UserNotification::where('user_id', $agent->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}