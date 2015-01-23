<?php
namespace Spatie\Glide;

use Intervention\Image\ImageManager;
use League\Glide\Api;
use League\Glide\Manipulators\Blur;
use League\Glide\Manipulators\Brightness;
use League\Glide\Manipulators\Contrast;
use League\Glide\Manipulators\Filter;
use League\Glide\Manipulators\Gamma;
use League\Glide\Manipulators\Orientation;
use League\Glide\Manipulators\Output;
use League\Glide\Manipulators\Pixelate;
use League\Glide\Manipulators\Rectangle;
use League\Glide\Manipulators\Sharpen;
use League\Glide\Manipulators\Size;

class GlideApiFactory {

    public static function create()
    {
        // Set image manager
        $imageManager = new ImageManager();

        // Set manipulators
        $manipulators = [
            new Orientation(),
            new Rectangle(),
            new Size(Config::get('laravel-glide::config.maxSize')),
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
}
