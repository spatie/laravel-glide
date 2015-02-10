<?php
namespace Spatie\Glide;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use League\Glide\Http\UrlBuilderFactory;
use Symfony\Component\HttpFoundation\Request;

class GlideImage
{
    protected $imagePath;

    protected $signKey;

    protected $baseURL;

    protected $modificationParameters = [];

    /**
     * Set the path to the image that needs to be converted
     *
     * @param $imagePath
     * @param array $modificationParameters = []
     * @return $this
     */
    public function load($imagePath, $modificationParameters = [])
    {
        $this->imagePath = $imagePath;

        $this->modify($modificationParameters);

        return $this;
    }

    /**
     * Set the base URL
     *
     * @param  string $baseURL
     * @return $this
     */
    public function setBaseURL($baseURL)
    {
        $this->baseURL = $baseURL;

        return $this;
    }

    /**
     * Set the signkey used to secure the image url
     *
     * @param $signKey
     * @return $this
     */
    public function setSignKey($signKey)
    {
        $this->signKey = $signKey;

        return $this;
    }

    /**
     * Set the modification parameters
     *
     * @param array $modificationParameters
     * @return $this
     */
    public function modify($modificationParameters)
    {
        $modificationParameters = $this->convertParametersToString($modificationParameters);

        $this->modificationParameters = $modificationParameters;

        return $this;
    }


    /**
     * Generate the url
     *
     * @return string
     */
    public function getURL()
    {
        $urlBuilder = UrlBuilderFactory::create('img', $this->signKey);

        return $urlBuilder->getUrl($this->imagePath, $this->modificationParameters);
    }

    /**
     * Save the image to the given outputFile
     *
     * @param $outputFile
     * @return string the URL to the saved image
     */
    public function save($outputFile)
    {
        $glideApi = GlideApiFactory::create();

        $inputImageData = file_get_contents(Config::get('laravel-glide::config.source.path').'/'.$this->imagePath);

        $outputImageData = $glideApi->run(Request::create(null, null, $this->modificationParameters), $inputImageData);

        file_put_contents($outputFile, $outputImageData);

        return $this->getURL();
    }

    /**
     * The string representation of this object is the URL to the image
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
     * @return array $modificationParameters
     */
    public function convertParametersToString($modificationParameters)
    {
        return array_map(function($value) {
            return  (string)$value;

        },$modificationParameters);

    }
}