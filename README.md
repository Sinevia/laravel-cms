# Laravel CMS #

[![Total Downloads](https://poser.pugx.org/sinevia/laravel-cms/downloads)](https://packagist.org/packages/sinevia/laravel-cms)
[![Latest Stable Version](https://poser.pugx.org/sinevia/laravel-cms/v/stable)](https://packagist.org/packages/sinevia/laravel-cms)
[![Latest Unstable Version](https://poser.pugx.org/sinevia/laravel-cms/v/unstable)](https://packagist.org/packages/sinevia/laravel-cms)
[![License](https://poser.pugx.org/sinevia/laravel-cms/license)](https://packagist.org/packages/sinevia/laravel-cms)
[![Monthly Downloads](https://poser.pugx.org/sinevia/laravel-cms/d/monthly)](https://packagist.org/packages/sinevia/laravel-cms)
[![Daily Downloads](https://poser.pugx.org/sinevia/laravel-cms/d/daily)](https://packagist.org/packages/sinevia/laravel-cms)
[![composer.lock](https://poser.pugx.org/sinevia/laravel-cms/composerlock)](https://packagist.org/packages/sinevia/laravel-cms)

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

- Install required library

```php
composer require lesichkovm/laravel-advanced-route
composer require lesichkovm/laravel-advanced-model
```

- Install the CMS
```php
composer require sinevia/laravel-cms
php artisan migrate
php artisan vendor:publish --tag=config
// If you want the migrations, usually not needed
php artisan vendor:publish --tag=migrations
// If you want the views, usually not  needed
php artisan vendor:publish --tag=views
```

Word of warning. Do use a stable package, as "dev-master" is a work in progress.

## Uninstall (est. 5 mins)##

Removal of the package is a breeze:

```php
composer remove sinevia/laravel-cms
```

Optionally, delete the CMS tables (all which start with the snv_cms_ prefix)

## Configuration

After running the vendor:publish command, the CMS settings will be published in the /config/cms.php config file. Check these out, and modify according to your taste


## Route Settings ##

1. CMS Endpoint (public, catch all)

```php
Route::group(['prefix' => '/'], function () {
    // will match only one level deep
    Route::any('/{path?}', '\Sinevia\Cms\Http\Controllers\CmsController@anyPageView');
    
    // or use with regex expression to match any level
    Route::any('/{path?}', '\Sinevia\Cms\Http\Controllers\CmsController@anyPageView')
        ->where('path', '([a-zA-z0-9\/\-]++)');
        
    // or use with simpler regex expression to match any level
    Route::any('/{path?}', '\Sinevia\Cms\Http\Controllers\CmsController@anyPageView')
        ->where('path', '.+');
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

## Templates ##

The templates are layouts, that can be used to display the pages in a uniform fashion. You may have multiple templates which is useful if you want to have different "look and feel" for different sections of your website.

## Pages ##

The pages are the content which displays when you visit a specified URL. Each page may have an optional parent template, which can specify common elements (i.e. style sheets, scripts, etc) for all pages sharing the template.

## Blocks ##

The blocks are small content snippets which can be embedded into pages and templates. Useful if you want to use on multiple pages, or to make pages more lightweight.

To embed in page or template use a shortcode like this: [[BLOCK_20180509052702261348]] 

## Widgets ##

The widgets are predefined dynamic modules which can be embedded into pages and templates (i.e. Google Maps, Contact Forms, etc). Depending on the action they perform, these may or may not have optional or requred parameters. Each widget files reside in its own directory.

To embed in page or template use a shortcode like this: [[WIDGET_20180509052702261348]]

More info: https://github.com/Sinevia/laravel-cms/wiki/Widgets

## Human Friendly Aliases ##
The following shortcuts can be used to create human friendly page aliases, that can be used for pages with dynamic content

|Shortcut | Regex |
| ------- |-------|
| :any    | ([^/]+) |
| :num    | ([0-9]+) |
| :all    | (.*) |
| :string | ([a-zA-Z]+) |
| :number | ([0-9]+) |
| :numeric | ([0-9-.]+) |
| :alpha' | ([a-zA-Z0-9-_]+) |

Example page alias: /article/:num/:string

To retrieve back you may use the following snippet
```php
preg_match('#^/article/([0-9]+)/([a-zA-Z]+)/([a-zA-Z]+)$#', '/' . $uri, $matched);
$articleId = $matched[1] ?? "";
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

### 5. Speed Test (before additional speed improvements)
![Alt text](screenshots/005_SpeedTest.png?raw=true "CMS. Speed Test")


## Changelog

2021.07.05 - Added support for Bootstrap 5

## Alternatives

- [LavaLite](https://github.com/LavaLite/cms) - requires full project from scratch, cannot be embedded in existing project as package
- [OctoberCms](https://github.com/octobercms/october) - requires full project from scratch, cannot be embedded in existing project as package
- [TypiCms](https://github.com/TypiCMS/Base) - requires full project from scratch, cannot be embedded in existing project as package
- [PyroCMS](https://github.com/pyrocms/pyrocms) - requires full project from scratch, cannot be embedded in existing project as package
- [Laravel8SimpleCms](https://github.com/ozdemirburak/laravel-8-simple-cms)  - requires full project from scratch, cannot be embedded in existing project as package
- [Winter](https://github.com/wintercms/winter)  - requires full project from scratch, cannot be embedded in existing project as package
- [GraphiteInc CMS](https://github.com/GrafiteInc/CMS) - Archived
- [Twil](https://github.com/area17/twill)
