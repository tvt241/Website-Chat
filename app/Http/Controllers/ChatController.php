<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function fetchMessages($id)
    {
        $messages = Message::query()
        ->where([
            ["user_id", auth()->id()],
            ["user_to", $id]
        ])
        ->orWhere([
            ["user_id", $id],
            ["user_to", auth()->id()]
        ])
        ->get();
        return MessageResource::collection($messages);
    }

    public function sendMessage(StoreMessageRequest $request)
    {
        $validated = $request->validated();
        $validated["user_id"] = auth()->id();
        $message = Message::create($validated);
        event(new MessageSent($request->user_to, $message));
        return ['status' => true];
    }
}
