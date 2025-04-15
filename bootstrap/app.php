<?php

use App\Exceptions\Handler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register route middleware here
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticatedRoleBased::class,
            'role' => \App\Http\Middleware\EnsureUserRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // dd($exceptions);
        // $exceptions->report(function (Handler $e) {
        //     // …
        // })->stop();
    
        $exceptions->render(using: function (Handler $e, Request $request) {
            return response()->json([
                'status' => false
            ]);
        });
    })->create();