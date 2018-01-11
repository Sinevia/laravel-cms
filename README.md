# Laravel CMS #

A "plug-and-play" content managing system (CMS) for Laravel that does its job and stays out of your way.

## Introduction ##

All of the existing Laravel CMS (OctoberCms, AsgardCms, PyroCms, etc) require a full installations from scratch. Its impossible to just add them to an exiting Laravel application, and even when added feel like you don't get what you hoped for.

This package allows to add a content management system as a package dependency in your composer file, which can be easily updated or removed as required to ANY Laravel app. It is fully self contained, and does not require any additional packages or dependencies. Removal is also a breeze just remove from your composer file.

## Features ##

- Templates (aka master layouts)
- Pages (web pages)
- Blocks (reusable cutom pieces of code -- headers, footers)
- Widgets (dynamic reusable pre-defined components)

## Installation (est. 5-10 mins) ##

```php
composer require sinevia/laravel-cms
```

Word of warning. Do use a stable package, as "dev-master" is a work in progress.

## Uninstall (est. 5 mins)##

Removal of the package is a breeze:

```php
composer require sinevia/laravel-cms
```

Optionally, delete the CMS tables (all which start with the snv_cms_ prefix)

## Usage ##

1. CMS Endpoint (public)

```php
Route::group(['prefix' => '/'], function () {
    Route::any('/{path?}', '\Sinevia\Cms\Http\Controllers\CmsController@anyPageView');
});
```

2. Admin endpoint (private, protect with middleware)

```php
Route::group(['prefix' => '/admin'], function () {
    Route::group(['middleware'=>'adminonly'], function(){
        AdvancedRoute::controller('/cms', '\Sinevia\Cms\Http\Controllers\CmsController');
    });
});
```
