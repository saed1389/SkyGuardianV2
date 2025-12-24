<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add security middleware - simple version
        $middleware->append([
            \Bepsvpt\SecureHeaders\SecureHeadersMiddleware::class,
            \Spatie\Csp\AddCspHeaders::class,
        ]);

        // Optional: Register Spatie Permission middleware aliases if installed
        // $middleware->alias([
        //     'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        //     'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        //     'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
