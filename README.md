# Laravel CMS #

A "plug-and-play" content managing system (CMS) for Laravel

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
