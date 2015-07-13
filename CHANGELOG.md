# Changelog

All notable changes to laravel-glide will be documented in this file.

## 1.1.0
- Added support for using multiple Filesystems
- in some cases the wrong mime-type was return. This is fixed.
- Fixing Issue that would create a invalid signature based on empty get parameters
- Fixed an issue where the controller would not work when the default namespace is not "App"
- Add support for potential route caching packages
- Added an option to disable the signing of urls
- Prevent slashes from being encoded in a generated url
- Fixed a bug where the baseURL from config would not be used

## 1.0.0
- Stable release for Laravel 4
- Made the method names less verbose

## 0.3.0
Support for Glide 0.3.0
