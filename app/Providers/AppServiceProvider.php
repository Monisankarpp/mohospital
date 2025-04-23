<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        Slot::class => SlotPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $role = $user->role ?? 'guest'; // fallback in case of guest
            $view->with('role', $role);
        });
        $this->registerPolicies();

    }
}
