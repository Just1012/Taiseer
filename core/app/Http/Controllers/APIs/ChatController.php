<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $ChatService;
    public function __construct(ChatService $ChatService)
    {
        $this->ChatService = $ChatService;
    }

    public function index($chatId)
    {
        $result = $this->ChatService->getMessages( $chatId);
          return apiResponse($result);
    }
    public function getChats()
    {
        $result = $this->ChatService->getChats();
          return apiResponse($result);
    }
    public function storeMessage(Request $request)
    {
        $result = $this->ChatService->storeMessage($request);
        return apiResponse($result);
    }
}
