<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'customer' => \App\Http\Middleware\EnsureUserIsCustomer::class,
            'ability' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'abilities' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        ]);
        
        // Add API logging middleware to API routes
        $middleware->api(prepend: [
            \App\Http\Middleware\ApiLogging::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
