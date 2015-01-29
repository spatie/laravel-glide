<?php
namespace Spatie\Glide;

use Illuminate\Support\Facades\Config;
use League\Glide\Http\UrlBuilderFactory;
use Symfony\Component\HttpFoundation\Request;

class GlideImage
{
    protected $imagePath;

    protected $signKey;

    protected $baseURL;

    protected $conversionParameters;

    /**
     * Set the path to the image that needs to be converted
     *
     * @param $imagePath
     * @return $this
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

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
     * Set the conversion parameters
     *
     * @param  mixed $conversionParameters
     * @return $this
     */
    public function setConversionParameters($conversionParameters)
    {
        $this->conversionParameters = $conversionParameters;

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

        return $urlBuilder->getUrl($this->imagePath, $this->conversionParameters);
    }

    /**
     * Save the image to the given outputFile
     *
     * @param $outputFile
     */
    public function saveImage($outputFile)
    {
        $glideApi = GlideApiFactory::create();

        $inputImageData = file_get_contents(Config::get('laravel-glide::config.source.path').'/'.$this->imagePath);

        $outputImageData = $glideApi->run(Request::create(null, null, $this->conversionParameters), $inputImageData);

        file_put_contents($outputFile, $outputImageData);
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
}
