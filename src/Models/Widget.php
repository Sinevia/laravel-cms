<?php

namespace Sinevia\Cms\Models;

class Widget extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_widget';
    
    public static function path($type = "") {
        $widgetsPath = trim(config('cms.paths.widgets', ''));
        
        if ($widgetsPath == '') {
            return '';
        }
        
        return resource_path($widgetsPath . '/' . trim($type));
    }
    
    public function render() {
        if ($this->Status != "Published") {
            return '';
        }
        
        $templateFilePath = self::path($this->Type) . '/template.phtml';
        if (file_exists($templateFilePath) == false) {
            return 'Template file does not exist';
        }
        
        $parameters = trim($this->Parameters) == "" ? [] : json_decode(trim($this->Parameters), true);
        return \Sinevia\Cms\Helpers\Template::fromFile($templateFilePath, $parameters);
    }

    public static function renderWidgets($string) {
        preg_match_all("|\[\[WIDGET_(.*)\]\]|U", $string, $out, PREG_PATTERN_ORDER);
        $widgetIds = $out[1];
        foreach ($widgetIds as $widgetId) {
            $widget = self::find($widgetId);
            $content = '';
            if ($widget != null) {
                $content = $widget->render();
            }
            $string = str_replace("[[WIDGET_$widgetId]]", $content, $string);
        }
        return $string;
    }
    
    public static function tableCreate() {
        $o = new self;

        if (\Schema::connection($o->connection)->hasTable($o->table) == true) {
            return true;
        }
        
        return \Schema::connection($o->connection)->create($o->table, function (\Illuminate\Database\Schema\Blueprint $table) use ($o) {
                    $table->engine = 'InnoDB';
                    $table->string($o->primaryKey, 40)->primary();
                    $table->string('ParentId', 40)->nullable()->default('');
                    $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
                    $table->string('Type', 40)->nullable()->default(NULL);
                    $table->string('Title', 255);
                    $table->integer('Sequence')->nullable()->default(NULL);
                    $table->integer('Cache')->nullable()->default(NULL);
                    $table->text('Parameters')->nullable()->default(NULL);
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
