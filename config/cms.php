<?php

/*
 * Set specific configuration variables here
 */
return [
    // automatic loading of routes through main service provider
    'routes' => true,
    // layout where the CMS will show into, i.e. admin.layouts.master
    'layout-master' => 'cms::admin.layout',
    // URLs
    'urls' => [
        'media-manager' => '/your-media-manager-url',
    ]
];
