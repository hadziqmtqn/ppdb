<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\ConversationRequest;
use App\Models\Conversation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConversationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Conversation::class);

        return Conversation::all();
    }

    public function store(ConversationRequest $request)
    {
        $this->authorize('create', Conversation::class);

        return Conversation::create($request->validated());
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        return $conversation;
    }

    public function update(ConversationRequest $request, Conversation $conversation)
    {
        $this->authorize('update', $conversation);

        $conversation->update($request->validated());

        return $conversation;
    }

    public function destroy(Conversation $conversation)
    {
        $this->authorize('delete', $conversation);

        $conversation->delete();

        return response()->json();
    }
}
