<?php

namespace Sinevia\Cms\Helpers;

class Links {

    public static function adminMediaManager($queryData = []) {
        return config('cms.urls.media-manager') . self::buildQueryString($queryData);
    }

    public static function page($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@anyPageView') . self::buildQueryString($queryData);
    }

    public static function adminHome($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@anyIndex') . self::buildQueryString($queryData);
    }

    public static function adminBlockManager($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getBlockManager') . self::buildQueryString($queryData);
    }

    public static function adminBlockCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postBlockCreate') . self::buildQueryString($queryData);
    }

    public static function adminBlockDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postBlockDelete') . self::buildQueryString($queryData);
    }

    public static function adminBlockMoveToTrash($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postBlockMoveToTrash') . self::buildQueryString($queryData);
    }

    public static function adminBlockUpdate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postBlockUpdate') . self::buildQueryString($queryData);
    }

    public static function adminBlockTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postBlockTranslationCreate') . self::buildQueryString($queryData);
    }

    public static function adminBlockTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postBlockTranslationDelete') . self::buildQueryString($queryData);
    }

    public static function adminPageManager($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getPageManager') . self::buildQueryString($queryData);
    }

    public static function adminPageCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postPageCreate') . self::buildQueryString($queryData);
    }

    public static function adminPageDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postPageDelete') . self::buildQueryString($queryData);
    }

    public static function adminPageMoveToTrash($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postPageMoveToTrash') . self::buildQueryString($queryData);
    }

    public static function adminPageUpdate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postPageUpdate') . self::buildQueryString($queryData);
    }

    public static function adminPageTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postPageTranslationCreate') . self::buildQueryString($queryData);
    }

    public static function adminPageTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postPageTranslationDelete') . self::buildQueryString($queryData);
    }

    public static function adminTemplateManager($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getTemplateManager') . self::buildQueryString($queryData);
    }

    public static function adminTemplateCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTemplateCreate') . self::buildQueryString($queryData);
    }

    public static function adminTemplateDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTemplateDelete') . self::buildQueryString($queryData);
    }

    public static function adminTemplateMoveToTrash($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTemplateMoveToTrash') . self::buildQueryString($queryData);
    }

    public static function adminTemplateUpdate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTemplateUpdate') . self::buildQueryString($queryData);
    }

    public static function adminTemplateTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTemplateTranslationCreate') . self::buildQueryString($queryData);
    }

    public static function adminTemplateTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTemplateTranslationDelete') . self::buildQueryString($queryData);
    }

    public static function adminTranslationCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTranslationCreate') . self::buildQueryString($queryData);
    }

    public static function adminTranslationDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTranslationDelete') . self::buildQueryString($queryData);
    }

    public static function adminTranslationManager($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getTranslationManager') . self::buildQueryString($queryData);
    }

    public static function adminTranslationUpdate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getTranslationUpdate') . self::buildQueryString($queryData);
    }
    
    public static function adminTranslationValueCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTranslationValueCreate') . self::buildQueryString($queryData);
    }
    
    public static function adminTranslationValueDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postTranslationValueDelete') . self::buildQueryString($queryData);
    }

    public static function adminWidgetManager($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getWidgetManager') . self::buildQueryString($queryData);
    }

    public static function adminWidgetCreate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postWidgetCreate') . self::buildQueryString($queryData);
    }

    public static function adminWidgetDelete($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@postWidgetDelete') . self::buildQueryString($queryData);
    }

    public static function adminWidgetPatametersFormAjax($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@anyWidgetParametersFormAjax') . self::buildQueryString($queryData);
    }

    public static function adminWidgetUpdate($queryData = []) {
        return action('\Sinevia\Cms\Http\Controllers\CmsController@getWidgetUpdate') . self::buildQueryString($queryData);
    }

    private static function buildQueryString($queryData = []) {
        $queryString = '';
        if (count($queryData)) {
            $queryString = '?' . http_build_query($queryData);
        }
        return $queryString;
    }

}
