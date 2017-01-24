<?php

namespace Spatie\Glide;

use Illuminate\Support\ServiceProvider;

class GlideServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-glide.php' => $this->app->configPath().'/'.'laravel-glide.php',
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-glide.php', 'laravel-glide');

        $this->app->bind('laravel-glide-image', function () {
            return new GlideImage();
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides() : array
    {
        return ['laravel-glide-image'];
    }
}
