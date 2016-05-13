<?php

namespace Spatie\Glide;

use Illuminate\Support\Facades\Config;
use Intervention\Image\ImageManager;
use League\Glide\Api\Api;
use League\Glide\Api\Manipulator\Blur;
use League\Glide\Api\Manipulator\Brightness;
use League\Glide\Api\Manipulator\Contrast;
use League\Glide\Api\Manipulator\Filter;
use League\Glide\Api\Manipulator\Gamma;
use League\Glide\Api\Manipulator\Orientation;
use League\Glide\Api\Manipulator\Output;
use League\Glide\Api\Manipulator\Pixelate;
use League\Glide\Api\Manipulator\Rectangle;
use League\Glide\Api\Manipulator\Sharpen;
use League\Glide\Api\Manipulator\Size;

class GlideApiFactory
{
    public static function create()
    {
        // Set image manager
        $imageManager = new ImageManager([
            'driver' => self::getDriver()
        ]);

        // Set manipulators
        $manipulators = [
            new Orientation(),
            new Rectangle(),
            new Size(Config::get('laravel-glide.maxSize')),
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
        return new Api($imageManager, $manipulators);
    }

    /**
     * @return string
     */
    public static function getDriver()
    {
        $driver = Config::get('laravel-glide.driver');

        if (! $driver) {
            $driver = 'gd';
        }

        return $driver;
    }
}
