<?php namespace Spatie\Glide\Controller;

use App\Http\Controllers\Controller;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Glide\Http\SignatureFactory;
use League\Glide\Server;
use Illuminate\Contracts\Foundation\Application;
use Spatie\Glide\GlideApiFactory;

class GlideImageController extends Controller {

    protected $app;
    protected $request;
    protected $glideConfig;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->glideConfig = config('laravel-glide');
        $this->request = $this->app['request'];
    }

    /**
     * Output a generated Glide-image
     */
    public function index()
    {
        $this->validateSignature();

        $this->writeIgnoreFile();

        $api = GlideApiFactory::create();

        $server = $this->setGlideServer($this->setImageSource(), $this->setImageCache(), $api);

        echo $server->outputImage($this->request);
    }

    /**
     * Validates the signature if useSecureURLs in enabled
     */
    protected function validateSignature()
    {
        if($this->glideConfig['useSecureURLs']) {
            SignatureFactory::create($this->app['config']->get('app.key'))
                ->validateRequest($this->request);
        }
    }

    /**
     *  Set the source path for images
     *
     * @return Filesystem
     */
    protected function setImageSource()
    {
        return (new Filesystem(new Local(
            $this->glideConfig['source']['path']
        )));
    }

    /**
     * Set the cache folder
     *
     * @return Filesystem
     */
    protected function setImageCache()
    {
        return (new Filesystem(new Local(
            $this->glideConfig['cache']['path']
        )));
    }

    /**
     * Configure the Glide Server with the baseURL
     *
     * @param $source
     * @param $cache
     * @param $api
     *
     * @return Server
     */
    protected function setGlideServer($source, $cache, $api)
    {
        $server = new Server($source, $cache,$api);

        $server->setBaseUrl($this->glideConfig['baseURL']);

        return $server;
    }

    /**
     * Copy the gitignore stub to the given directory
     */
    public function writeIgnoreFile()
    {
        $destinationFile = $this->glideConfig['cache']['path'].'/.gitignore';

        if (!file_exists($destinationFile)) {
            $this->app['files']->copy(__DIR__.'/../../stubs/gitignore.txt', $destinationFile);
        }
    }
}