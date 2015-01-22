# A Glide Server Provider for Laravel
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ad0422ca-e31f-44a3-b01a-ee5ec757b18d/mini.png)](https://insight.sensiolabs.com/projects/ad0422ca-e31f-44a3-b01a-ee5ec757b18d)
[![Latest Stable Version](https://poser.pugx.org/spatie/laravel-glide/version.png)](https://packagist.org/packages/spatie/laravel-glide)
[![License](https://poser.pugx.org/spatie/laravel-glide/license.png)](https://packagist.org/packages/spatie/laravel-glide)

This package provides a Service Provider that allows you to very easily integrate [Glide](http://glide.thephpleague.com/) into a Laravel project.

[Glide](http://glide.thephpleague.com/) is a easy on-demand image manipulation library written in PHP. It's part of the [League of Extraordinary Packages](http://thephpleague.com/).

Using this package you'll be able to generate image manipulations on the fly and generate URL's to those images. These URL's will be signed so only you will be able to specify which manipulations should be generated. Every manipulation will be cached.

## Installation


You can install the package through Composer.

```bash
composer require spatie/laravel-glide
```

You must install this service provider.

```php

// Laravel 4: app/config/app.php

'providers' => [
    ...
    'Spatie\Glide\GlideServiceProvider',
    ...
];
```

This package also comes with a facade, which provides an easy way to generate images.

```php

// Laravel 4: app/config/app.php

'aliases' => array(
	...
    'GlideImage'       => 'Spatie\Glide\GlideImageFacade',
    ...
)
```


You can publish the config file of the package using artisan.

```bash
php artisan config:publish spatie/laravel-glide
```

The config file looks like this:
```php

return [
    /*
     * URLs to generated images will start with this string
     *
     */
    'baseURL' => 'img',

    /*
     * The adapter and parameters that Glide will use as input
     * You should put your original images in this directory
     *
     */
    'source' => [
            'adapter' => 'local',
            'path' => storage_path('images'),
        ],

    /*
     * The adapter and parameters that Glide will use for caching images
     * A .gitignore file will be automatically placed in this directory
     * so you don't accidentally end up committing these images
     *
     */
    'cache' => [
            'adapter' => 'local',
            'path' => storage_path('glide-cache'),
        ],

    /*
     * The maximum allowed total image size in pixels
     */
    'maxSize' => 2000 * 2000
];
```


The options in the config file are set with sane default values and they should be self-explanatory.

## Usage 

Assuming you've got an image named "kayaks.jpg" in "app/storage/images" (= the default input directory) you can use this code in a blade view:


```php
<img src="{{ GlideImage::setImagePath('kayaks.jpg')->setConversionParameters(['w'=> 50, 'filt'=>'greyscale']) }}" />
```

The function will output an URL to a greyscale version of kayaks.jpg that has a width of 50 pixels. As soon as the URL gets hit by your browser, the image will be generated on the fly. The generated image will be saved in "app/storage/glide-cache" (= the default cache directory).

Take a look at [the image API of Glide](http://glide.thephpleague.com/api/size/) to see which parameters you can pass to the ```setConversionParameters```-method.
