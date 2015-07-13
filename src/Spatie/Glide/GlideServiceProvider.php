<?php namespace Spatie\Glide;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->package('spatie/laravel-glide');

        $glideConfig = $this->app['config']->get('laravel-glide::config');

        $this->app['router']->get($glideConfig['baseURL'].'/{disk?}/{all}', 'Spatie\Glide\Controller\GlideImageController@index')->where('all', '.*');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('laravel-glide-image', function () {

            $glideConfig = $this->app['config']->get('laravel-glide::config');

            $glideImage = new GlideImage();
            $glideImage
                ->setSignKey($this->getSignKey($glideConfig))
                ->setBaseURL($glideConfig['baseURL']);

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
     * Check the configuration to return the correct signKey
     *
     * @param $glideConfig
     * @return null
     */
    public function getSignKey($glideConfig)
    {
        if(! isset($glideConfig['useSecureURLs']))
        {
            return $this->app['config']->get('app.key');
        }

        if ($glideConfig['useSecureURLs'] === true)
        {
            return $this->app['config']->get('app.key');
        }

        return null;
    }
}
