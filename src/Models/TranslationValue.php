<?php

namespace Sinevia\Cms\Models;

class TranslationValue extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_translation_value';
    public $timestamps = false;

    public static function tableCreate() {
        $o = new self();

        if (\Schema::connection($o->connection)->hasTable($o->table) == false) {
            $result = \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                $table->engine = 'InnoDB';
                $table->string($o->primaryKey, 40)->primary();
                $table->string('KeyId', 40)->index();
                $table->string('Laguage', 2)->index();
                $table->text('Value')->nullable()->default(null);
                $table->datetime('CreatedAt')->nullable()->default(null);
                $table->datetime('UpdatedAt')->nullable()->default(null);
            });
        }

        return true;
    }

    public static function tableDelete() {
        $o = new self();
        return \Schema::connection($o->connection)->drop($o->table);
    }

}
