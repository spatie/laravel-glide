# Easily convert images with Glide
[![Latest Version](https://img.shields.io/github/release/spatie/laravel-glide.svg?style=flat-square)](https://github.com/spatie/laravel-glide/releases)
[![Build status](https://img.shields.io/travis/spatie/laravel-glide.svg)](https://travis-ci.org/spatie/laravel-glide)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ad0422ca-e31f-44a3-b01a-ee5ec757b18d/mini.png)](https://insight.sensiolabs.com/projects/ad0422ca-e31f-44a3-b01a-ee5ec757b18d)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-glide.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-glide)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/29484127/shield?branch=master)](https://styleci.io/repos/29484127)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-glide.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-glide)

This package provides an easy to use class to manipulate images. Under the hood it leverages [Glide](http://glide.thephpleague.com/) to perform 
the manipulations.

Here's an example of how the package can be used:

```php
GlideImage::create($pathToImage)
	->modify(['w'=> 50, 'filt'=>'greyscale'])
	->save($pathToWhereToSaveTheManipulatedImage);
```

## Installation

You can install the package through Composer.

```bash
composer require spatie/laravel-glide
```

In Laravel 5.5 the service provider and facade will automatically get registered. In older versions of the framework just add the service provider and facade in `config/app.php` file:

```php
'providers' => [
    ...
    Spatie\Glide\GlideServiceProvider::class,
    ...
];

...

'aliases' => [
	...
    'GlideImage' => Spatie\Glide\GlideImageFacade::class,
    ...
]
```


You can publish the config file of the package using artisan.

```bash
php artisan vendor:publish --provider="Spatie\Glide\GlideServiceProvider"
```

The config file looks like this:
```php

<?php

return [

    /*
     * The driver that will be used to create images. Can be set to gd or imagick.
     */
    'driver' => 'gd',
];

```
## Usage 

Here's a quick example that shows how an image can be modified:

```php
GlideImage::create($pathToImage)
	->modify(['w'=> 50, 'filt'=>'greyscale'])
	->save($pathToWhereToSaveTheManipulatedImage);
```

Take a look at [Glide's image API](http://glide.thephpleague.com/1.0/api/quick-reference/) to see which parameters you can pass to the `modify`-method.

## Testing

You can run the tests with:

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Previous versions

Previous versions of this package had PHP 5.4 support and the ability to generate 
images on the fly from an url.

The previous versions are unsupported, but they should still work in your older projects.

- [Version 2 branch with Laravel 5 support](https://github.com/spatie/laravel-glide/tree/v2)
- [Version 1 branch with Laravel 4 support](https://github.com/spatie/laravel-glide/tree/laravel-4)

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https:/murze.be)
- [All Contributors](https://github.com/freekmurze/laravel-glide/contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [LICENSE](https://github.com/freekmurze/laravel-glide/blob/master/LICENSE) for more information.

