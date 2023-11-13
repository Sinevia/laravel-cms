<?php

namespace Sinevia\Cms\Models;

class TranslationKey extends BaseModel {

    protected $table = 'snv_cms_translation_key';
    public $timestamps = true;

    public static function translate($key, $language = 'en') {
        $translationKey = self::where('Key', $key)->first();
        if (is_null($translationKey)) {
            return 'n/a';
        }
        $translationValue = TranslationValue::where('KeyId', $translationKey->Id)->where('Language', $language)->first();
        if (is_null($translationValue) AND $language != 'en') {
            $translationValue = TranslationValue::where('KeyId', $translationKey->Id)->where('Language', 'en')->first();
        }
        if (is_null($translationValue)) {
            return $key . ' ' . $language . ' n/a';
        }
        return $translationValue->Value;
    }

    public static function tableCreate() {
        $o = new self();

        if (\Schema::connection($o->connection)->hasTable($o->table) == false) {
            $result = \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                $table->engine = 'InnoDB';
                $table->string($o->primaryKey, 40)->primary();
                $table->string('Key', 255)->index();
                $table->datetime('CreatedAt')->nullable()->default(null);
                $table->datetime('UpdatedAt')->nullable()->default(null);
                $table->datetime('DeletedAt')->nullable()->default(null);
            });
        }

        return true;
    }

    public static function tableDelete() {
        $o = new self();
        return \Schema::connection($o->connection)->drop($o->table);
    }

}
