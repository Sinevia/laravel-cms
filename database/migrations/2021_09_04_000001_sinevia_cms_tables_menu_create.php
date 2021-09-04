<?php

class SineviaCmsTablesMenuCreate extends Illuminate\Database\Migrations\Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Sinevia\Cms\Models\Menu::tableCreate();
        Sinevia\Cms\Models\MenuItem::tableCreate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Sinevia\Cms\Models\Menu::tableDelete();
        Sinevia\Cms\Models\MenuItem::tableDelete();
    }

}
