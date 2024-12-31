<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappMessage\MessageTemplateRequest;
use App\Models\MessageTemplate;

class MessageTemplateController extends Controller
{
    public function index()
    {
        return MessageTemplate::all();
    }

    public function store(MessageTemplateRequest $request)
    {
        return MessageTemplate::create($request->validated());
    }

    public function show(MessageTemplate $messageTemplate)
    {
        return $messageTemplate;
    }

    public function update(MessageTemplateRequest $request, MessageTemplate $messageTemplate)
    {
        $messageTemplate->update($request->validated());

        return $messageTemplate;
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        $messageTemplate->delete();

        return response()->json();
    }
}
