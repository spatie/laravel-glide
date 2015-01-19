<?php

return [
    /*
     * The base URL where Glide will listen for requests
     */
    'baseURL' => 'img',

    /*
     * The adapter and parameters that Glide will use as input
     */
    'source' => [
            'adapter' => 'local',
            'path' => storage_path('images'),
        ],

    /*
     * The adapter and parameters that Glide will use for caching images
     */
    'cache' => [
            'adapter' => 'local',
            'path' => storage_path('glide/cache'),
        ],

    /*
     * The maximum allowed total image size in pixels
     */
    'maxSize' => 2000 * 2000
];
