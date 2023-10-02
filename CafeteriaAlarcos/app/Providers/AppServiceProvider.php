<?php

namespace App\Providers;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

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
        Paginator::useBootstrapFive();

        Blade::directive('money', function ($money) {
            return "{{ number_format($money, 2) }}€";
        });

        if (Schema::hasTable('users')) {
            Cache::rememberForever('userRequests', function () {
                return User::doesntHave('roles')->count();
            });
        }

        if (Schema::hasTable('configurations')) {
            Cache::rememberForever('precioMenu', function () {
                return Configuration::where('name', 'precioMenu')->value('value');
            });
        }
    }
}
