<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = Message::query();
        
        if (in_array(auth()->user()->role, ['admin', 'super_admin']) && $request->has('user_id')) {
            $otherUserId = $request->user_id;
            $query->where(function ($q) use ($otherUserId) {
                $q->where('sender_id', $otherUserId)
                  ->orWhere('receiver_id', $otherUserId);
            });
            // Mark customer messages to admin as read
            Message::where('sender_id', $otherUserId)
                ->whereNull('receiver_id')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            // Mark admin messages to customer as read only when read parameter is 1
            if ($request->input('read') == 1) {
                Message::where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }
        }
        
        $messages = $query->with('sender')->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'receiver_id' => 'nullable|integer',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov,pdf|max:10240'
        ]);

        if (empty($request->content) && !$request->hasFile('attachment')) {
            return response()->json(['error' => 'กรุณากรอกข้อความหรือเลือกไฟล์แนบ'], 422);
        }

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat_attachments', 'public');
            @mkdir(dirname(public_path('storage/' . $attachmentPath)), 0777, true);
            @copy(storage_path('app/public/' . $attachmentPath), public_path('storage/' . $attachmentPath));
            
            $mime = $file->getMimeType();
            if (str_starts_with($mime, 'image/')) {
                $attachmentType = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $attachmentType = 'video';
            } else {
                $attachmentType = 'file';
            }
        }

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content ?? '',
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
