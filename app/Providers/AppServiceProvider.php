<?php

namespace App\Providers;

use App\Observers\TaskObserver;
use App\Task;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //-- Make all urls secure
        if (env('APP_FORCE_SECURE', false)) {
            $laravel = app();
            $version = $laravel::VERSION;
            if(version_compare($version, '5.4.0', '>')) {
                URL::forceScheme('https');
            } else {
                URL::forceSchema('https');
            }
        }

        if (env('APP_ENV', 'production') === 'production') {
            \Debugbar::disable();
        }

        Task::observe(TaskObserver::class);

        Blade::directive('datetime', function ($expression) {
            return "($expression instanceOf \\DateTime) ? ($expression)->format('m/d/Y g:i A') : (new \\DateTime($expression))->format('m/d/Y g:i A')";
        });
        Blade::directive('date', function ($expression) {
            return "($expression instanceOf \\Date || $expression instanceOf \\DateTime) ? ($expression)->format('m/d/Y') : (new \\DateTime($expression))->format('m/d/Y')";
        });
        Blade::directive('full_url', function ($expression) {
            return "(Request::secure()) ? secure_url($expression) : url($expression)";
        });

        Blade::directive('full_asset', function ($expression) {
            return "(env('APP_USE_CDN', false)) ? Cdn::asset($expression) : asset($expression)";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
