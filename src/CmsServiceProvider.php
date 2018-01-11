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
        $this->publishes([
            dirname(__DIR__) . '/config/cms.php' => config_path('cms.php'),
            $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations'),
            $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'cms'),
            //$this->loadRoutesFrom(dirname(__DIR__).'/routes.php'),            
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
