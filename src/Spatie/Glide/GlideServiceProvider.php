<?php

namespace Spatie\Glide;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class GlideServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/laravel-glide.php' => config_path('laravel-glide.php'),
        ], 'config');

        $glideConfig = config('laravel-glide');

        $this->app['router']->get($glideConfig['baseURL'].'/{all}', 'Spatie\Glide\Controller\GlideImageController@index')->where('all', '.*');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-glide.php', 'laravel-glide');

        $this->app->bind('laravel-glide-image', function () {

            $glideImage = new GlideImage();

            $glideImage
                ->setSignKey($this->getSignKey(config('laravel-glide')))
                ->setBaseURL($this->app['config']->get('laravel-glide.baseURL'));

            return $glideImage;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-glide', 'laravel-glide-image'];
    }

    /**
     * Copy the gitignore stub to the given directory.
     *
     * @param $directory
     */
    public function writeIgnoreFile($directory)
    {
        $destinationFile = $directory.'/.gitignore';

        if (!file_exists($destinationFile)) {
            $this->app['files']->copy(__DIR__.'/../../stubs/gitignore.txt', $destinationFile);
        }
    }

    /**
     * Check the configuration to return the correct signKey.
     *
     * @param $glideConfig
     */
    public function getSignKey($glideConfig)
    {
        if (!isset($glideConfig['useSecureURLs'])) {
            return Config::get('app.key');
        }

        if ($glideConfig['useSecureURLs'] === true) {
            return Config::get('app.key');
        }

        return;
    }
}
