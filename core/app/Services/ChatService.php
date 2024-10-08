<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class ChatService
{

    public function getChats()
    {
        try {
            $userId = auth()->user()->id;

            // Fetch chats where messages are sent by the authenticated user
            $chats = Chat::whereHas('messages', function ($query) use ($userId) {
                $query->where('sender_id', $userId);
            })->paginate();

            // Check if the chat list is empty
            if ($chats->isEmpty()) {
                return [
                    'status' => 404,
                    'message' => 'No Chats Available for You',
                    'data' => $chats,
                ];
            }

            return [
                'status' => 200,
                'message' => 'Chats retrieved successfully',
                'data' => $chats,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ];
        }
    }

    public function getMessages($chatID)
    {
        try {
            $userId = auth()->user()->id;
            $chats = Chat::where('id', $chatID)
                ->whereHas('messages', function ($query) use ($userId) {
                    $query->where('sender_id', $userId);
                })->first();

            if (!$chats) {
                return [
                    'status' => 404,
                    'message' => 'No Permission for you to see this Chat',
                ];
            }

            $message = Message::where('chat_id', $chatID)
                ->latest()
                ->paginate();

            if ($message->isEmpty()) {
                return [
                    'status' => 200,
                    'message' => 'No Message Available for You',
                ];
            }
            return [
                'status' => 200,
                'message' => 'message retrieved successfully',
                'data' => $message,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ];
        }
    }

    public function storeMessage($request)
    {
        try {
            // Define validation rules
            $rules = [
                'shipment_id' => 'required|exists:shipments,id',
                'message_text' => 'required|string',
            ];

            $messages = [
                'message_text.required' => 'The message text is required.',
            ];

            // Validate the incoming request
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                // Return an array with error details instead of a RedirectResponse
                return [
                    'error' => true,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ];
            }

            // If validation passes, proceed to handle the message
            $messageText = $request->message_text;

            if ($messageText) {
                $shipmentId = $request->shipment_id;

                // Check if a chat for the shipment already exists or create a new one
                $chat = Chat::where('shipment_id', $shipmentId)->first();
                if (!$chat) {
                    $chat = Chat::create([
                        'name' => 'Shipment# ' . $shipmentId,
                        'shipment_id' => $shipmentId,
                    ]);
                }

                // Create a new message in the chat
                $newMessage = Message::create([
                    'chat_id' => $chat->id,
                    'message_text' => $messageText,
                    'sender_id' => auth()->user()->id, // Assuming the sender is authenticated
                ]);

                // Return useful data such as the created message and chat
                return [
                    'status' => 200,
                    'data' => [$chat, $newMessage],
                    'message' => 'Chat created and message sent successfully',
                ];
            }

            // If no message is provided, return an error response
            return [
                'status' => 400,
                'message' => 'No message text provided',
            ];
        } catch (Exception $e) {
            // Return an array with the error message instead of a RedirectResponse
            return [
                'status' => 500,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ];
        }
    }
}
