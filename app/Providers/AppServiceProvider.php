<?php

namespace App\Providers;

use App\Models\Avatar;
use App\Observers\AvatarObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Avatar::observe(AvatarObserver::class);
    }
}
