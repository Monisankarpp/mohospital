<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register route middleware
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticatedRoleBased::class,
            'role' => \App\Http\Middleware\EnsureUserRole::class,
            'doctor.first.login' => \App\Http\Middleware\CheckDoctorFirstLogin::class,
        ]);

        // You can also add other middleware groups if needed
        // $middleware->append([]);
        // $middleware->prepend([]);
    })
    ->withCommands()
    ->withSchedule(function (Schedule $schedule) {
        // Register scheduled commands
        $schedule->command('slots:manage')->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();