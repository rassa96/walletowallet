<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all messages for this user's conversation with admin
        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark all admin messages as read
        ChatMessage::where('user_id', $user->id)
            ->where('is_from_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('chat', compact('user', 'messages'));
    }
    
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        
        $user = Auth::user();
        
        ChatMessage::create([
            'user_id' => $user->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'is_from_admin' => false,
            'is_read' => false,
        ]);
        
        return redirect()->route('chat.index');
    }
    
    public function fetch()
    {
        $user = Auth::user();
        
        $messages = ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'message' => $m->message,
                    'is_from_admin' => $m->is_from_admin,
                    'time' => $m->created_at->format('h:i A'),
                    'date' => $m->created_at->format('M d'),
                ];
            });
        
        // Mark admin messages as read
        ChatMessage::where('user_id', $user->id)
            ->where('is_from_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['messages' => $messages]);
    }
}
