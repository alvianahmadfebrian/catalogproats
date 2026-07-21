<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // --- USER CHAT ENDPOINTS ---

    public function userMessages()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Mark admin messages as read for this user
        Message::where('user_id', $userId)
            ->where('is_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_admin' => $msg->is_admin,
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d M'),
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function userSend(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'user_id' => $userId,
            'message' => $validated['message'],
            'is_admin' => false,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => false,
                'time' => $message->created_at->format('H:i'),
                'date' => $message->created_at->format('d M'),
            ]
        ]);
    }

    // --- ADMIN CHAT ENDPOINTS ---

    public function adminIndex()
    {
        return view('admin.chat.index');
    }

    public function adminConversations()
    {
        // Get all unique users who have sent or received messages
        $userIds = Message::select('user_id')
            ->groupBy('user_id')
            ->pluck('user_id');

        $conversations = User::whereIn('id', $userIds)
            ->get()
            ->map(function ($user) {
                $lastMsg = Message::where('user_id', $user->id)
                    ->latest()
                    ->first();

                $unreadCount = Message::where('user_id', $user->id)
                    ->where('is_admin', false)
                    ->where('is_read', false)
                    ->count();

                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
                    'last_message' => $lastMsg ? $lastMsg->message : '',
                    'last_time' => $lastMsg ? $lastMsg->created_at->format('H:i') : '',
                    'unread_count' => $unreadCount,
                ];
            })
            ->sortByDesc(function ($item) {
                return $item['unread_count'] > 0 ? 1 : 0;
            })
            ->values();

        return response()->json(['conversations' => $conversations]);
    }

    public function adminMessages($userId)
    {
        // Mark user messages as read when admin opens thread
        Message::where('user_id', $userId)
            ->where('is_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $user = User::findOrFail($userId);

        $messages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_admin' => $msg->is_admin,
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d M'),
                ];
            });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
            ],
            'messages' => $messages
        ]);
    }

    public function adminSend(Request $request, $userId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'user_id' => $userId,
            'message' => $validated['message'],
            'is_admin' => true,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => true,
                'time' => $message->created_at->format('H:i'),
                'date' => $message->created_at->format('d M'),
            ]
        ]);
    }

    public function adminUnreadCount()
    {
        $count = Message::where('is_admin', false)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}
