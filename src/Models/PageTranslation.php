<?php

namespace Sinevia\Cms\Models;

class PageTranslation extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_pagetranslation';
    public $primaryKey = 'Id';
    public $timestamps = false;
    public $incrementing = false;
    public $useMicroId = true;
    
    public static function tableCreate() {
        $o = new self;

        if (\Schema::connection($o->connection)->hasTable($o->table) == true) {
            return true;
        }
        
        return \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                    $table->engine = 'InnoDB';
                    $table->string($o->primaryKey, 40)->primary();
                    $table->string('PageId', 40);
                    $table->string('Language', 2)->default('en');
                    $table->string('Title', 255)->default('');
                    $table->text('Summary')->nullable();
                    $table->text('Content')->nullable();
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