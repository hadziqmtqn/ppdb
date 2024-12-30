<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationRequest;
use App\Models\Application;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ApplicationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('application-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('application-write'), only: ['store']),
        ];
    }

    public function index(): View
    {
        $title = 'Aplikasi';

        return view('dashboard.application.index', compact('title'));
    }

    public function store(ApplicationRequest $request)
    {
        try {
            $application = Application::firstOrNew();
            $application->name = $request->input('name');
            $application->description = $request->input('description');
            $application->website = $request->input('website');
            $application->main_website = $request->input('main_website');
            $application->register_verification = $request->input('register_verification');
            $application->notification_method = $request->input('notification_method');
            $application->save();

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                if ($application->hasMedia('logo')) {
                    $application->clearMediaCollection('logo');
                }

                $application->addMedia($request->file('logo'))->toMediaCollection('logo');
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
