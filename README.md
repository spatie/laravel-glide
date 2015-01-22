# A Glide Server Provider for Laravel
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ad0422ca-e31f-44a3-b01a-ee5ec757b18d/mini.png)](https://insight.sensiolabs.com/projects/ad0422ca-e31f-44a3-b01a-ee5ec757b18d)
[![Latest Stable Version](https://poser.pugx.org/spatie/laravel-glide/version.png)](https://packagist.org/packages/spatie/laravel-glide)
[![License](https://poser.pugx.org/spatie/laravel-glide/license.png)](https://packagist.org/packages/spatie/laravel-glide)

This package provides a Service Provider that allows you to very easily integrate [Glide](http://glide.thephpleague.com/) into a Laravel project.

[Glide](http://glide.thephpleague.com/) is a easy on-demand image manipulation library written in PHP. It's part of the [League of Extraordinary Packages](http://thephpleague.com/).

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

This package also comes with a facade, which provides an easy way generate images.

```php

// Laravel 4: app/config/app.php

'aliases' => array(
	...
    'GlideImage'       => 'Spatie\Glide\GlideImageFacade',
)
```


You can publish the config file of the package using artisan.

```bash
php artisan config:publish spatie/laravel-glide
```

The options in the config file are set with sane default values and they should be self-explanatory.

## Usage 

Coming soon...
