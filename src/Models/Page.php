<?php

namespace Sinevia\Cms\Models;

class Page extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_page';
    public $primaryKey = 'Id';
    public $timestamps = false;
    public $incrementing = false;
    public $useMicroId = true;

    public function createVersion() {
        $pageWithTranslationsArray = $this->toArray();
        $version = Version::createVersion('CmsPage', $this->Id, $pageWithTranslationsArray);
        if(is_null($version)==false){
            return true;
        }
        return false;
    }

    public function translations() {
        return $this->hasMany('Sinevia\Cms\Models\PageTranslation', 'PageId');
    }

    public function translation($languageCode) {
        return $this->translations()->where('Language', '=', $languageCode)->first();
    }

    public function url() {
        return self::getUrl($this);
    }

    /**
     * Returns the URL to the page
     * @param type $id
     */
    public static function getUrl($id) {
        $page = is_object($id) ? $id : Page::find($id);

        if ($page == null) {
            return '#page-notfound-' . $id;
        }

        return \Sinevia\Cms\Helpers\Links::page() . '/' . ltrim($page->Alias, '/');

        if ($page['Alias'] == '') {
            $url = '/page/' . $page['Id'] . '/' . \Sinevia\Utils::stringSlugify($page['Title']);
        } else {
            if ($page['Alias'] == "/") {
                $url = '/';
            } else {
                $url = '/' . trim($page['Alias'], '/');
            }
        }

        return $url;
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
                    $table->string('TemplateId', 40)->nullable()->default('');
                    $table->string('Alias', 255)->nullable()->default('');
                    $table->string('Access', 20)->default('Public');
                    $table->string('MetaKeywords', 255)->nullable()->default('');
                    $table->string('MetaDescription', 255)->nullable()->default('');
                    $table->string('MetaRobots', 40)->nullable()->default('');
                    $table->string('CanonicalUrl', 255)->nullable()->default('');
                    $table->string('Wysiwyg', 20)->default('None');
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
