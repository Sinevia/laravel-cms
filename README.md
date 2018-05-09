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
php artisan migrate
php artisan vendor:publish
```

Word of warning. Do use a stable package, as "dev-master" is a work in progress.

## Uninstall (est. 5 mins)##

Removal of the package is a breeze:

```php
composer remove sinevia/laravel-cms
```

Optionally, delete the CMS tables (all which start with the snv_cms_ prefix)

# Configuration Settings
After running the vendor:publish command, the CMS settings will be published in the /config/cms.php config file. Check these out, and modify according to your taste


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

## Quick Snippets

1. Advanced usage. Use the CMS templates to wrap around custom code with blade templates:

```php
// A small helper function to place HTML in the CMS template
function viewInTemplate($pageTitle, $pageContent) {
    $template = \Sinevia\Cms\Models\Template::find('20180126000128528925');

    return $template->render('en', [
                'page_title' => $pageTitle,
                'page_content' => $pageContent,
    ]);
}

// Then you may use from your controller, for instance to show a login form in
$html = view('guest/auth/login', get_defined_vars())->render();
return viewInTemplate('Login', $pageContent)
```

## Screenshots

### 1. Page Manager
![Alt text](screenshots/001_PageManager.png?raw=true "CMS. Page Manager")

### 2. Create New Page
![Alt text](screenshots/002_PageAddNew.png?raw=true "CMS. Create New Page")

### 3. Edit Page. Content View
![Alt text](screenshots/003_PageEdit.png?raw=true "CMS. Edit Page. Content View")

### 4. Edit Page. SEO View
![Alt text](screenshots/004_PageEdit_SeoView.png?raw=true "CMS. Edit Page. SEO View")


