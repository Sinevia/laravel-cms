<?php

require __DIR__ . '/../vendor/autoload.php';

/*
 * Stub AdvancedModel if the lesichkovm/laravel-advanced-model package
 * is not installed. This allows tests to run standalone.
 */
if (!class_exists('AdvancedModel')) {
    class AdvancedModel extends \Illuminate\Database\Eloquent\Model
    {
        public $useUniqueId = false;
        public $useMicroId = false;

        protected static function boot()
        {
            parent::boot();

            static::creating(function ($model) {
                if ($model->incrementing === false && empty($model->{$model->getKeyName()})) {
                    if (isset($model->useMicroId) && $model->useMicroId) {
                        $model->{$model->getKeyName()} = substr(
                            md5(uniqid((string) rand(), true)),
                            0,
                            40
                        );
                    } elseif (isset($model->useUniqueId) && $model->useUniqueId) {
                        $model->{$model->getKeyName()} = uniqid();
                    }
                }
            });
        }
    }
}
