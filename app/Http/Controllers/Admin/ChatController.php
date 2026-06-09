<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin != 1) {
            abort(403);
        }
        
        // Get all users who have at least one chat message, with their latest message and unread count
        $conversations = User::whereHas('chatMessages')
            ->with(['chatMessages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->get()
            ->map(function ($user) {
                $latest = $user->chatMessages->first();
                $unread = ChatMessage::where('user_id', $user->id)
                    ->where('is_from_admin', false)
                    ->where('is_read', false)
                    ->count();
                
                return [
                    'user' => $user,
                    'latest_message' => $latest,
                    'unread_count' => $unread,
                ];
            })
            ->sortByDesc(function ($c) {
                return $c['latest_message'] ? $c['latest_message']->created_at : null;
            })
            ->values();
        
        return view('admin.chat-list', compact('conversations'));
    }
    
    public function show($userId)
    {
        if (Auth::user()->is_admin != 1) {
            abort(403);
        }
        
        $user = User::findOrFail($userId);
        
        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark user's messages as read
        ChatMessage::where('user_id', $userId)
            ->where('is_from_admin', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('admin.chat-conversation', compact('user', 'messages'));
    }
    
    public function send(Request $request, $userId)
    {
        if (Auth::user()->is_admin != 1) {
            abort(403);
        }
        
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        
        $admin = Auth::user();
        
        ChatMessage::create([
            'user_id' => $userId,
            'sender_id' => $admin->id,
            'message' => $request->message,
            'is_from_admin' => true,
            'is_read' => false,
        ]);
        
        return redirect()->route('admin.chat.show', $userId);
    }
}
