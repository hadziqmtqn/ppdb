<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappConfig\WhatsappConfigRequest;
use App\Models\WhatsappConfig;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class WhatsappConfigController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('whatsapp-config-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('whatsapp-config-write'), only: ['store']),
        ];
    }

    public function index(): View
    {
        $title = 'Konfig. Whatsapp';
        $whatsappConfig = WhatsappConfig::firstOrFail();

        return view('dashboard.settings.whatsapp-config.index', compact('title', 'whatsappConfig'));
    }

    public function store(WhatsappConfigRequest $request)
    {
        try {
            $whatsappConfig = WhatsappConfig::firstOrNew();
            $whatsappConfig->domain = $request->input('domain');
            $whatsappConfig->api_key = $request->input('api_key');
            $whatsappConfig->is_active = $request->input('is_active');
            $whatsappConfig->save();
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
