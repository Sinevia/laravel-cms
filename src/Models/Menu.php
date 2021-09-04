<?php

namespace Sinevia\Cms\Models;

class Menu extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_menu';
    public $primaryKey = 'Id';
    public $timestamps = true;
    public $incrementing = false;
    public $useMicroId = true;

    const STATUS_DRAFT = 'Draft';
    const STATUS_PUBLISHED = 'Published';
    const STATUS_UNPUBLISHED = 'Unpublished';
    const STATUS_DELETED = 'Deleted';

    public function menuitems() {
        return $this->hasMany('Sinevia\Cms\Models\MenuItem', 'MenuId');
    }

    public function treeMenuItems($parentId = null) {
        $menuitems = $this->menuitems()->where("ParentId", $parentId)->orderBy('Sequence', 'ASC')->get();
        foreach ($menuitems as $index => $menuitem) {
            $children = $this->treeMenuItems($menuitem->Id);
            $menuitem->children = $children;
            $menuitems[$index] = $menuitem;
        }
        return $menuitems;
    }

    public static function tableCreate() {
        $o = new self;

        if (\Schema::connection($o->connection)->hasTable($o->table) == true) {
            return true;
        }

        return \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                    $table->engine = 'InnoDB';
                    $table->string($o->primaryKey, 40)->primary();
                    $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
                    $table->string('Title', 255)->nullable()->default('');
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
