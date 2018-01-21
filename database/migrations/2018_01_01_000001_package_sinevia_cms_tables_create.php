<?php

class PackageSineviaCmsTablesCreate extends Illuminate\Database\Migrations\Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Sinevia\Cms\Models\Template::tableCreate();
        Sinevia\Cms\Models\TemplateTranslation::tableCreate();
        Sinevia\Cms\Models\Page::tableCreate();
        Sinevia\Cms\Models\PageTranslation::tableCreate();
        Sinevia\Cms\Models\Block::tableCreate();
        Sinevia\Cms\Models\BlockTranslation::tableCreate();
        Sinevia\Cms\Models\Widget::tableCreate();
        Sinevia\Cms\Models\Version::tableCreate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Sinevia\Cms\Models\Template::tableDelete();
        Sinevia\Cms\Models\TemplateTranslation::tableDelete();
        Sinevia\Cms\Models\Page::tableDelete();
        Sinevia\Cms\Models\PageTranslation::tableDelete();
        Sinevia\Cms\Models\Block::tableDelete();
        Sinevia\Cms\Models\BlockTranslation::tableDelete();
        Sinevia\Cms\Models\Widget::tableDelete();
        Sinevia\Cms\Models\Version::tableDelete();
    }

}
