<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappMessage\MessageTemplateRequest;
use App\Models\MessageTemplate;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class MessageTemplateController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('message-template-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('message-template-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('message-template-delete'), only: ['destroy']),
        ];
    }

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
