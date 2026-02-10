<?php

use App\Http\Middleware\Role;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SetLocale;
use Bepsvpt\SecureHeaders\SecureHeadersMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Csp\AddCspHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'api/n8n/save-image',
            'n8n/save-image', // Add this too just in case
            'api/sensor/heartbeat', // Bu adresi hariç tut
            'sensor/heartbeat',
        ]);
        $middleware->alias([
            'role' => Role::class,
            'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
            $middleware->append([
                SecureHeadersMiddleware::class,
                AddCspHeaders::class,
                SecurityHeaders::class,
                SetLocale::class,
            ])
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
