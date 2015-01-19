<?php

return [
    /*
     * The path were Glide will listen for request
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
     * The maximum allow total image size in pixels
     */
    'maxSize' => 2000 * 2000
];
