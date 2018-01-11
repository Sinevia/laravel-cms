<?php

namespace Sinevia\Cms\Models;

class Version extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_version';
    
    public static function tableCreate() {
        $o = new self;

        if (\Schema::connection($o->connection)->hasTable($o->table) == true) {
            return true;
        }
        
        return \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                    $table->engine = 'InnoDB';
                    $table->string($o->primaryKey, 40)->primary();
                    $table->string('EntityType', 20)->nullable()->default(NULL);
                    $table->string('EntityId', 20);
                    $table->longtext('Data')->nullable()->default(NULL);
                    $table->datetime('CreatedAt')->nullable()->default(NULL);
                    $table->datetime('UpdatedAt')->nullable()->default(NULL);
                    $table->datetime('DeletedAt')->nullable()->default(NULL);
                });
    }

    public static function tableDelete() {
        $o = new self;
        
        if (\Schema::connection($o->connection)->hasTable($o->table) == false) {
            return true;
        }
        
        return \Schema::connection($o->connection)->drop($o->table);
    }
}