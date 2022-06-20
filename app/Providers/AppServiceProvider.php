<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Illuminate\Support\Collection::macro('recursive', function () {
            return \Illuminate\Support\Collection::wrap($this)->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return \Illuminate\Support\Collection::wrap($value)->recursive();
                }

                return $value;
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
