<?php

return [
    /*
     * The adapter and parameters that Glide will use as input
     * You should put your original images in this directory
     *
     */
    'source' => [
        'path' => storage_path('images'),
    ],

    /*
     * The adapter and parameters that Glide will use for caching images
     * A .gitignore file will be automatically placed in this directory
     * so you don't accidentally end up committing these images
     *
     */
    'cache' => [
        'path' => storage_path('glide-cache'),
    ],

    /*
     * URLs to generated images will start with this string
     *
     */
    'baseURL' => 'img',

    /*
     * The maximum allowed total image size in pixels
     */
    'maxSize' => 2000 * 2000
];
