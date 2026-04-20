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
        $middleware->alias([
            'farmer' => \App\Http\Middleware\EnsureFarmer::class,
            'admin'  => \App\Http\Middleware\EnsureAdmin::class,
        ]);
        // Public read-only endpoints don't need CSRF; all mutating routes do
        $middleware->validateCsrfTokens(except: [
            'api/state',
            'api/farmers',
            'api/farmers/*',
            'api/products',
            'api/products/*',
            'api/search',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
