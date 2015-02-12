<?php namespace Spatie\Glide;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Glide\Http\SignatureFactory;
use League\Glide\Server;

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
        //$glideConfig = $this->app['config']->get('laravel-glide::config');

        $this->publishes([
            __DIR__.'/../../config/laravel-glide.php' => config_path('laravel-glide.php'),
        ], 'config');

        $glideConfig = config('laravel-glide');

        $this->app['router']->get($glideConfig['baseURL'].'/{all}', function () use ($glideConfig) {

            $request = $this->app['request'];

            SignatureFactory::create($this->app['config']->get('app.key'))->validateRequest($request);

            // Set image source
            $source = new Filesystem(
                new Local($glideConfig['source']['path'])
            );

            // Set image cache
            $cache = new Filesystem(
                new Local($glideConfig['cache']['path'])
            );
            $this->writeIgnoreFile($glideConfig['cache']['path']);

            $api = GlideApiFactory::create();

            // Setup Glide server
            $server = new Server($source, $cache, $api);

            $server->setBaseUrl($glideConfig['baseURL']);

            echo $server->outputImage($request);

        })->where('all', '.*');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

       $this->app->bind('laravel-glide-image', function () {


            $glideImage = new GlideImage();
            $glideImage
                ->setSignKey($this->app['config']->get('app.key'))
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
     * Copy the gitignore stub to the given directory
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
}
