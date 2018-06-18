<?php

namespace Sinevia\Cms\Models;

class Block extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_block';
    protected $primaryKey = 'Id';
    public $timestamps = true;
    public $incrementing = false;
    public $useMicroId = true;

    public function createVersion() {
        $blockWithTranslationsArray = $this->toArray();
        $version = Version::createVersion('CmsBlock', $this->Id, $blockWithTranslationsArray);
        if (is_null($version) == false) {
            return true;
        }
        return false;
    }
    
    public static function renderBlocks($string) {
        preg_match_all("|\[\[BLOCK_(.*)\]\]|U", $string, $out, PREG_PATTERN_ORDER);
        $blockIds = $out[1];
        foreach ($blockIds as $blockId) {
            $block = \Sinevia\Cms\Models\Block::find($blockId);
            if ($block != null) {
                $blockTranslation = $block->translation('en');
                $blockContent = $blockTranslation->Content;
            } else {
                $blockContent = '';
            }
            $blockContentDynamic = \Sinevia\Cms\Helpers\Template::fromString($blockContent);
            $string = str_replace("[[BLOCK_$blockId]]", $blockContentDynamic, $string);
        }
        return $string;
    }

    public function restoreVersion($versionId) {
        $version = Version::find($versionId);
        if (is_null($version)) {
            return false;
        }
        $data = $version->getData();
        if (is_null($data)) {
            return false;
        }
        
        //$translations = isset($data['translations'])
        //$title = isset($data['Title']) ? $data['Title'] : '';
    }

    public function translations() {
        return $this->hasMany('Sinevia\Cms\Models\BlockTranslation', 'BlockId');
    }

    public function translation($languageCode) {
        return $this->translations()->where('Language', '=', $languageCode)->first();
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
                    $table->string('Title', 255);
                    $table->text('Content')->nullable()->default(NULL);
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
