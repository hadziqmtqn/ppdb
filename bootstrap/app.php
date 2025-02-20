<?php

use App\Http\Middleware\AccountVerifiedMiddleware;
use App\Http\Middleware\OnlyAdminMiddleware;
use App\Http\Middleware\RegistrationIsCompletedMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\VerificationProcessMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'account_verified' => AccountVerifiedMiddleware::class,
            'verification_process' => VerificationProcessMiddleware::class,
            'student_access' => StudentMiddleware::class,
            'only_admin' => OnlyAdminMiddleware::class,
            'registration_is_completed' => RegistrationIsCompletedMiddleware::class
        ]);

        $middleware->validateCsrfTokens(except: [
            'payment-webhook'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
