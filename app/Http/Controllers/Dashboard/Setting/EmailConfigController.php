<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailConfig\EmailConfigRequest;
use App\Models\EmailConfig;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class EmailConfigController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('email-config-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('email-config-write'), only: ['store']),
        ];
    }

    public function index(): View
    {
        $title = 'Konfig. Email';
        $emailConfig = EmailConfig::firstOrFail();

        return \view('dashboard.settings.email-config.index', compact('title', 'emailConfig'));
    }

    public function store(EmailConfigRequest $request)
    {
        try {
            $emailConfig = EmailConfig::firstOrNew();
            $emailConfig->mail_username = $request->input('mail_username');
            $emailConfig->mail_password_app = $request->input('mail_password_app');
            $emailConfig->is_active = $request->input('is_active');
            $emailConfig->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
