<?php
class SineviaCmsTablesTranslationCreate extends Illuminate\Database\Migrations\Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Sinevia\Cms\Models\TranslationKey::tableCreate();
        Sinevia\Cms\Models\TranslationValue::tableCreate();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Sinevia\Cms\Models\TranslationKey::tableDelete();
        Sinevia\Cms\Models\TranslationValue::tableDelete();
    }
}
