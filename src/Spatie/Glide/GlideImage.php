<?php

namespace Spatie\Glide;

use Illuminate\Support\Facades\Config;
use League\Glide\Http\UrlBuilderFactory;
use Symfony\Component\HttpFoundation\Request;

class GlideImage
{
    protected $sourceFile;

    protected $signKey;

    protected $baseURL;

    protected $modificationParameters = [];

    protected $useAbsolutePath = false;

    /**
     * Set the path to the image that needs to be converted.
     *
     * @param $sourceFile
     * @param array $modificationParameters = []
     *
     * @return $this
     */
    public function load($sourceFile, $modificationParameters = [])
    {
        $this->sourceFile = $sourceFile;

        $this->modify($modificationParameters);

        return $this;
    }

    /**
     * Set the base URL.
     *
     * @param string $baseURL
     *
     * @return $this
     */
    public function setBaseURL($baseURL)
    {
        $this->baseURL = $baseURL;

        return $this;
    }

    /**
     * Set the signkey used to secure the image url.
     *
     * @param $signKey
     *
     * @return $this
     */
    public function setSignKey($signKey)
    {
        $this->signKey = $signKey;

        return $this;
    }

    /**
     * Set the modification parameters.
     *
     * @param array $modificationParameters
     *
     * @return $this
     */
    public function modify($modificationParameters)
    {
        $modificationParameters = $this->convertParametersToString(array_filter($modificationParameters));

        $this->modificationParameters = $modificationParameters;

        return $this;
    }

    /**
     * Generate the url.
     *
     * @return string
     */
    public function getURL()
    {
        $urlBuilder = UrlBuilderFactory::create($this->baseURL, $this->signKey);

        $encodedPath = implode('/', array_map('rawurlencode', explode('/', $this->sourceFile)));

        return $urlBuilder->getUrl($encodedPath, $this->modificationParameters);
    }

    /**
     * Save the image to the given outputFile.
     *
     * @param $outputFile
     *
     * @return string the URL to the saved image
     */
    public function save($outputFile)
    {
        $glideApi = GlideApiFactory::create();

        $outputImageData = $glideApi->run(Request::create(null, null, $this->modificationParameters), $this->getPathToImage());

        file_put_contents($outputFile, $outputImageData);

       /*
        * Triggering the garbage collection solves a memory leak in an underlying package.
        */
        gc_collect_cycles();

        return $this->getURL();
    }

    /**
     * The string representation of this object is the URL to the image.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl();
    }

    /**
     * Cast 'w' & 'h' modificationParameters to string to fix the ctype_digit issue.
     *
     * @param array $modificationParameters
     *
     * @return array $modificationParameters
     */
    public function convertParametersToString($modificationParameters)
    {
        return array_map(function ($value) {
            return  (string) $value;

        }, $modificationParameters);
    }

    /**
     * Use an absolute path to the sourceFile (instead of using config source).
     *
     * @return $this
     */
    public function useAbsoluteSourceFilePath()
    {
        $this->useAbsolutePath = true;

        return $this;
    }

    /**
     * Get the path to the image.
     *
     * @return string
     */
    private function getPathToImage()
    {
        if ($this->useAbsolutePath) {
            return $this->sourceFile;
        }

        return Config::get('laravel-glide.source.path').'/'.$this->sourceFile;
    }
}
