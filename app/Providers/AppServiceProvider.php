<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Vite::createAssetPathsUsing(function (string $path) {
            return '/' . $path;
        });

        if (str_contains(config('app.url'), 'ngrok-free.dev')) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }
    }
}