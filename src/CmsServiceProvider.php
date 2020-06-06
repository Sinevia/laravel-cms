<?php

namespace Sinevia\Cms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'cms');
        //$this->loadRoutesFrom(dirname(__DIR__).'/routes.php'),         

        $this->publishes([
            dirname(__DIR__) . '/config/cms.php' => config_path('cms.php'),
            dirname(__DIR__) . '/database/migrations' => database_path('migrations'),
            dirname(__DIR__) . '/resources/views' => resource_path('views/cms'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
