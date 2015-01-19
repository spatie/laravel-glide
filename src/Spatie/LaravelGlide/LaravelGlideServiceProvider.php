<?php namespace Spatie\LaravelGlide;

use Illuminate\Support\ServiceProvider;

class LaravelGlideServiceProvider extends ServiceProvider {

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
		$this->package('spatie/searchindex');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['router']->get($this->app['config']->get('laravel-glide::config.baseURL') . '/{all}', function() {



			$request = $this->app['request'];

			HttpSignature::create($this->app['config']->get('app.key'))->validateRequest($request);

			// Set image source
			$source = new Filesystem(
				new Local($this->app['config']->get('laravel-glide::config.source.path'))
			);

			// Set image cache
			$cache = new Filesystem(
				new Local($this->app['config']->get('laravel-glide::config.cache.path'))
			);

			// Set image manager
			$imageManager = new ImageManager();

			// Set manipulators
			$manipulators = [
				new Orientation(),
				new Rectangle(),
				new Size($this->app['config']->get('laravel-glide::config.maxSize')),
				new Brightness(),
				new Contrast(),
				new Gamma(),
				new Sharpen(),
				new Filter(),
				new Blur(),
				new Pixelate(),
				new Output(),
			];

			// Set API
			$api = new Api($imageManager, $manipulators);

			// Setup Glide server
			$server = new Server($source, $cache, $api, $this->app['config']->get('app.key'));

			$server->setBaseUrl($this->app['config']->get('laravel-glide::config.baseURL'));

			echo $server->outputImage($request);

		})->where('all', '.*');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
