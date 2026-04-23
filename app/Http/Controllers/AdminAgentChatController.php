<?php

namespace App\Http\Controllers;

use App\Models\AdminAgentMessage;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class AdminAgentChatController extends Controller
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

    protected function ensureRole(User $user, string $role): void
    {
        if ($user->role !== $role) {
            abort(404);
        }
    }

    protected function buildContacts(User $currentUser, string $targetRole)
    {
        $contacts = User::where('role', $targetRole)
            ->where('status', 'active')
            ->orderBy('username')
            ->get();

        return $contacts->map(function ($contact) use ($currentUser) {
            $lastMessage = AdminAgentMessage::where(function ($query) use ($currentUser, $contact) {
                $query->where('sender_id', $currentUser->id)
                    ->where('receiver_id', $contact->id);
            })->orWhere(function ($query) use ($currentUser, $contact) {
                $query->where('sender_id', $contact->id)
                    ->where('receiver_id', $currentUser->id);
            })->latest()->first();

            $unreadCount = AdminAgentMessage::where('sender_id', $contact->id)
                ->where('receiver_id', $currentUser->id)
                ->where('is_read', false)
                ->count();

            return [
                'contact' => $contact,
                'lastMessage' => $lastMessage,
                'unreadCount' => $unreadCount,
            ];
        })->sortByDesc(function ($row) {
            return $row['lastMessage']?->created_at?->timestamp ?? 0;
        })->values();
    }

    protected function getConversationMessages(User $firstUser, User $secondUser)
    {
        return AdminAgentMessage::with(['sender', 'receiver'])
            ->where(function ($query) use ($firstUser, $secondUser) {
                $query->where('sender_id', $firstUser->id)
                    ->where('receiver_id', $secondUser->id);
            })
            ->orWhere(function ($query) use ($firstUser, $secondUser) {
                $query->where('sender_id', $secondUser->id)
                    ->where('receiver_id', $firstUser->id);
            })
            ->orderBy('created_at')
            ->get();
    }

    protected function markConversationMessagesAsRead(User $viewer, User $otherUser): void
    {
        AdminAgentMessage::where('sender_id', $otherUser->id)
            ->where('receiver_id', $viewer->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    protected function markConversationNotificationsAsRead(User $viewer, User $otherUser, string $type): void
    {
        UserNotification::where('user_id', $viewer->id)
            ->where('type', $type)
            ->where('related_user_id', $otherUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function agentIndex(?User $adminUser = null)
    {
        $agent = $this->currentAgent();

        if ($adminUser) {
            $this->ensureRole($adminUser, 'admin');
        }

        $contacts = $this->buildContacts($agent, 'admin');

        if (!$adminUser && $contacts->isNotEmpty()) {
            $adminUser = $contacts->first()['contact'];
        }

        $messages = collect();

        if ($adminUser) {
            $this->markConversationMessagesAsRead($agent, $adminUser);
            $this->markConversationNotificationsAsRead($agent, $adminUser, 'admin_chat_message');
            $contacts = $this->buildContacts($agent, 'admin');
            $messages = $this->getConversationMessages($agent, $adminUser);
        }

        return view('agent.chat-admin', [
            'agent' => $agent,
            'contacts' => $contacts,
            'selectedAdmin' => $adminUser,
            'messages' => $messages,
        ]);
    }

    public function agentSend(Request $request, User $adminUser)
    {
        $agent = $this->currentAgent();
        $this->ensureRole($adminUser, 'admin');

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ], [
            'message.required' => 'Le message est obligatoire.',
            'message.max' => 'Le message ne doit pas dépasser 4000 caractères.',
        ]);

        AdminAgentMessage::create([
            'sender_id' => $agent->id,
            'receiver_id' => $adminUser->id,
            'message' => $validated['message'],
            'is_read' => false,
            'read_at' => null,
        ]);

        UserNotification::create([
            'user_id' => $adminUser->id,
            'type' => 'agent_chat_message',
            'title' => 'Nouveau message agent',
            'message' => "{$agent->username} vous a envoyé un message dans le chat.",
            'ticket_id' => null,
            'related_user_id' => $agent->id,
            'is_read' => false,
            'read_at' => null,
        ]);

        return redirect()->route('agent.chat.index', ['adminUser' => $adminUser->id]);
    }

    public function adminIndex(?User $agentUser = null)
    {
        $admin = $this->currentAdmin();

        if ($agentUser) {
            $this->ensureRole($agentUser, 'agent');
        }

        $contacts = $this->buildContacts($admin, 'agent');

        if (!$agentUser && $contacts->isNotEmpty()) {
            $agentUser = $contacts->first()['contact'];
        }

        $messages = collect();

        if ($agentUser) {
            $this->markConversationMessagesAsRead($admin, $agentUser);
            $this->markConversationNotificationsAsRead($admin, $agentUser, 'agent_chat_message');
            $contacts = $this->buildContacts($admin, 'agent');
            $messages = $this->getConversationMessages($admin, $agentUser);
        }

        return view('admin.chat-agents', [
            'admin' => $admin,
            'contacts' => $contacts,
            'selectedAgent' => $agentUser,
            'messages' => $messages,
        ]);
    }

    public function adminSend(Request $request, User $agentUser)
    {
        $admin = $this->currentAdmin();
        $this->ensureRole($agentUser, 'agent');

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ], [
            'message.required' => 'Le message est obligatoire.',
            'message.max' => 'Le message ne doit pas dépasser 4000 caractères.',
        ]);

        AdminAgentMessage::create([
            'sender_id' => $admin->id,
            'receiver_id' => $agentUser->id,
            'message' => $validated['message'],
            'is_read' => false,
            'read_at' => null,
        ]);

        UserNotification::create([
            'user_id' => $agentUser->id,
            'type' => 'admin_chat_message',
            'title' => 'Nouveau message admin',
            'message' => "{$admin->username} vous a envoyé un message dans le chat.",
            'ticket_id' => null,
            'related_user_id' => $admin->id,
            'is_read' => false,
            'read_at' => null,
        ]);

        return redirect()->route('admin.chat.index', ['agentUser' => $agentUser->id]);
    }
}