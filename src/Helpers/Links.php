<?php

namespace Sinevia\Cms\Helpers;

class Links {
    public static function adminMediaManager($queryData = []){
        return config('cms.urls.media-manager') . self::buildQueryString($queryData);
        return action('\Sinevia\Cms\Controllers\CmsController@anyPageView') . self::buildQueryString($queryData);
    }
    public static function page($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@anyPageView') . self::buildQueryString($queryData);
    }

    public static function adminHome($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@anyIndex') . self::buildQueryString($queryData);
    }
    
    public static function adminBlockManager($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@getBlockManager') . self::buildQueryString($queryData);
    }

    public static function adminBlockCreate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postBlockCreate') . self::buildQueryString($queryData);
    }
    
    public static function adminBlockDelete($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postBlockDelete') . self::buildQueryString($queryData);
    }
    
    public static function adminBlockMoveToTrash($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postBlockMoveToTrash') . self::buildQueryString($queryData);
    }

    public static function adminBlockUpdate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postBlockUpdate') . self::buildQueryString($queryData);
    }
    
    public static function adminBlockTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postBlockTranslationCreate') . self::buildQueryString($queryData);
    }
    public static function adminBlockTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postBlockTranslationDelete') . self::buildQueryString($queryData);
    }

    public static function adminPageManager($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@getPageManager') . self::buildQueryString($queryData);
    }

    public static function adminPageCreate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postPageCreate') . self::buildQueryString($queryData);
    }
    
    public static function adminPageDelete($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postPageDelete') . self::buildQueryString($queryData);
    }
    
    public static function adminPageMoveToTrash($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postPageMoveToTrash') . self::buildQueryString($queryData);
    }

    public static function adminPageUpdate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postPageUpdate') . self::buildQueryString($queryData);
    }
    
    public static function adminPageTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postPageTranslationCreate') . self::buildQueryString($queryData);
    }
    public static function adminPageTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postPageTranslationDelete') . self::buildQueryString($queryData);
    }
    
    public static function adminTemplateManager($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@getTemplateManager') . self::buildQueryString($queryData);
    }

    public static function adminTemplateCreate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postTemplateCreate') . self::buildQueryString($queryData);
    }
    
    public static function adminTemplateDelete($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postTemplateDelete') . self::buildQueryString($queryData);
    }
    
    public static function adminTemplateMoveToTrash($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postTemplateMoveToTrash') . self::buildQueryString($queryData);
    }

    public static function adminTemplateUpdate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postTemplateUpdate') . self::buildQueryString($queryData);
    }
    
    public static function adminTemplateTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postTemplateTranslationCreate') . self::buildQueryString($queryData);
    }
    public static function adminTemplateTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Controllers\CmsController@postTemplateTranslationDelete') . self::buildQueryString($queryData);
    }

    private static function buildQueryString($queryData = []) {
        $queryString = '';
        if (count($queryData)) {
            $queryString = '?' . http_build_query($queryData);
        }
        return $queryString;
    }

}
