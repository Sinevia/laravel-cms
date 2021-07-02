<?php

/*
 * Set specific configuration variables here
 */
return [
    // automatic loading of routes through main service provider
    'routes' => true,
    // layout where the CMS will show into, i.e. admin.layouts.master
    'layout-master' => 'cms::admin.layout',
    // Bootstrap CSS version
    'bootstrap-version' => '4',
    // URLs
    'urls' => [
        'media-manager' => '/your-media-manager-url',
    ],
    'paths' => [
        // path to widgets, in your resources directory
        'widgets' => 'widgets',
    ],
];
