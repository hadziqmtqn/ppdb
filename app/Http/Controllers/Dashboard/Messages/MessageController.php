<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\MessageRequest;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        return Message::all();
    }

    public function store(MessageRequest $request)
    {
        return Message::create($request->validated());
    }

    public function show(Message $message)
    {
        return $message;
    }

    public function update(MessageRequest $request, Message $message)
    {
        $message->update($request->validated());

        return $message;
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json();
    }
}
