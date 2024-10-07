<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function getChats()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();

        // Count of chats with unread messages
        $unreadChatsCount = Chat::whereHas('messages', function ($query) {
            $query->where('is_read', 0);
        })->count();

        // Count of chats with read messages
        $readChatsCount = Chat::whereHas('messages', function ($query) {
            $query->where('is_read', 1);
        })->count();

        // Count of all chats
        $allChatsCount = Chat::count();
        return view('dashboard.inbox.list', compact('GeneralWebmasterSections', 'unreadChatsCount', 'readChatsCount', 'allChatsCount'));
    }

    public function fetchChatMessages($chatId)
    {
        $chat = Chat::with('messages.sender')->findOrFail($chatId);
        Message::where('chat_id', $chatId)->update(['is_read' => 1]);
        $messages = $chat->messages->map(function ($message) {
            return [
                'message_text' => $message->message_text,
                'sender_name' => $message->sender->name,
                'created_at' => Carbon::parse($message->created_at)->diffForHumans(),
                'hover_time' => Carbon::parse($message->created_at)->format('d/m/Y h:i A'),
                'is_user' => $message->sender->company_id
            ];
        });
        return response()->json([
            'chat' => [
                'id' => $chat->id,
                'name' => $chat->name,
            ],
            'messages' => $messages,
        ]);
    }

    public function getAllChats()
    {
        $chats = Chat::withCount('messages') // Total messages count
            ->withCount(['messages as unread_messages_count' => function ($query) {
                $query->where('is_read', 0); // Count only unread messages
            }])->get();

        return response()->json($chats);
    }

    public function getUnreadChats()
    {
        $chats = Chat::whereHas('messages', function ($query) {
            $query->where('is_read', 0); // Filter chats with unread messages
        })
            ->withCount('messages') // Total messages count
            ->withCount(['messages as unread_messages_count' => function ($query) {
                $query->where('is_read', 0); // Count unread messages
            }])->get();

        return response()->json($chats);
    }

    public function getReadChats()
    {
        $chats = Chat::whereHas('messages', function ($query) {
            $query->where('is_read', 1); // Filter chats with read messages
        })
            ->withCount('messages') // Total messages count
            ->withCount(['messages as unread_messages_count' => function ($query) {
                $query->where('is_read', 0); // Count unread messages (for completeness)
            }])->get();

        return response()->json($chats);
    }


    public function storeMessage(Request $request)
    {
        // Validation rules for the message
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|exists:chats,id',
            'message_text' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400); // Bad request due to validation failure
        }

        // Store the new message
        $message = Message::create([
            'chat_id' => $request->chat_id,
            'message_text' => $request->message_text,
            'sender_id' => auth()->user()->id, // Assuming the sender is the currently authenticated user
        ]);

        // Return the newly created message in the response
        return response()->json([
            'message' => 'Message sent successfully',
            'data' => [
                'message_text' => $message->message_text,
                'sender_name' => auth()->user()->name,
                'created_at' => $message->created_at->diffForHumans(),
            ]
        ], 200); // OK
    }

    public function searchChats(Request $request)
    {
        $query = $request->get('q');

        // Search chats based on the query
        $chats = Chat::where('name', 'LIKE', '%' . $query . '%')
            ->withCount('messages') // Count all messages
            ->withCount(['messages as unread_messages_count' => function ($query) {
                $query->where('is_read', 0); // Count unread messages
            }])
            ->get(); // Fetch results

        // Return the search results as JSON
        return response()->json([
            'chats' => $chats
        ]);
    }
}
