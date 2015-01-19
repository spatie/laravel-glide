<?php
namespace Spatie\Glide;

use Config;
use League\Glide\Factories\UrlBuilder;

class GlideImage
{
    protected $imageURL;

    protected $conversionParameters;

    /**
     * Set the image URL that needs to be converted
     *
     * @param $imageURL
     * @return $this
     */
    public function setImageURL($imageURL)
    {
        $this->imageURL = $imageURL;

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
        $urlBuilder = UrlBuilder::create('img', Config::get('app.key'));

        return $urlBuilder->getUrl($this->imageURL, $this->conversionParameters);
    }
}
