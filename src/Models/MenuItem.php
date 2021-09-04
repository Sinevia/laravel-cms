<?php

namespace Sinevia\Cms\Models;

class MenuItem extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_menuitem';
    public $primaryKey = 'Id';
    public $timestamps = true;
    public $incrementing = false;
    public $useMicroId = true;
    
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED = 'deleted';

    public static function tableCreate() {
        $o = new self;

        if (\Schema::connection($o->connection)->hasTable($o->table) == true) {
            return true;
        }

        return \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                    $table->engine = 'InnoDB';
                    $table->string($o->primaryKey, 40)->primary();
                    $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
                    $table->string('MenuId', 40);
                    $table->string('ParentId', 40)->nullable()->default('');
                    $table->string('Sequence', 40)->nullable()->default('');
                    $table->string('Title', 255)->nullable()->default('');
                    $table->string('Url', 510)->nullable()->default('');
                    $table->string('PageId', 40)->nullable()->default('');
                    $table->string('Target', 20)->nullable()->default('');
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
