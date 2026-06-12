<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Artikel;
use App\Models\User;
use App\Models\Komentar;
use App\Observers\ArtikelObserver;
use App\Observers\UserObserver;
use App\Observers\KomentarObserver;

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
        Artikel::observe(ArtikelObserver::class);
        User::observe(UserObserver::class);
        Komentar::observe(KomentarObserver::class);
    }
}
