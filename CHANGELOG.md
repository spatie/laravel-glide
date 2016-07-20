# Changelog

All notable changes to laravel-glide will be documented in this file.

## 2.3.4 - 2016-07-20

- fixed a bug where `GlideImageController` would output the result twice

## 2.3.3 - 2016-05-13

- fix for invalid driver when serviceProvider is not registered

## 2.3.2 - 2016-05-13

- make sure the default values from the config file are being used

## 2.3.1 - 2016-05-11
*This version contains a breaking bug, do not use*

- fixed the tagging issue of 2.3.0

## 2.3.0
*This version is wrongly tagged, do not use*

- image driver is now configurable
- fixed the maxsize option
- code reformatted for psr2

## 2.2.8
- fixed issue that prevented Glide from accessing exif data.

## 2.2.7
- removing constraint on Intervention package.

## 2.2.6
- temporary add constraint on Intervention package while investigating exif exception.

## 2.2.5
- fix memory leak.

## 2.2.4
- in some cases the wrong mime-type was return. This is fixed.

## 2.2.3
- Fixing Issue that would create a invalid signature based on empty get parameters

## 2.2.2
- Moved github repo from freekmurze to spatie

## 2.2.1
- Fixed an issue where the controller would not work when the default namespace is not "App"

## 2.2.0
- Add support for Laravel 5's route caching

## 2.1.0
- Added an option to disable the signing of urls

## 2.0.2
- Prevent slashes from being encoded in a generated url

## 2.0.1
- Fixed a bug where the baseURL from config would not be used

## 2.0.0
- Stable release for Laravel 5

## 1.0.0
- Stable release for Laravel 4
- Made the method names less verbose

## 0.3.0
Support for Glide 0.3.0
