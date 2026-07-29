<?php

namespace Sinevia\Cms\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Sinevia\Cms\CmsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            CmsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createCmsTables();
    }

    protected function createCmsTables(): void
    {
        \Schema::connection('testing')->create('snv_cms_page', function ($table) {
            $table->string('Id', 40)->primary();
            $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
            $table->string('TemplateId', 40)->nullable()->default('');
            $table->string('Alias', 255)->nullable()->default('');
            $table->string('Access', 20)->default('Public');
            $table->string('MetaKeywords', 255)->nullable()->default('');
            $table->string('MetaDescription', 255)->nullable()->default('');
            $table->string('MetaRobots', 40)->nullable()->default('');
            $table->string('CanonicalUrl', 255)->nullable()->default('');
            $table->string('Wysiwyg', 20)->default('None');
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_pagetranslation', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('PageId', 40);
            $table->string('Language', 2)->default('en');
            $table->string('Title', 255)->default('');
            $table->text('Summary')->nullable();
            $table->text('Content')->nullable();
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_template', function ($table) {
            $table->string('Id', 40)->primary();
            $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
            $table->string('Title', 255);
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_templatetranslation', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('TemplateId', 40);
            $table->string('Language', 2)->default('en');
            $table->text('Content')->nullable();
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_block', function ($table) {
            $table->string('Id', 40)->primary();
            $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
            $table->string('Title', 255);
            $table->text('Content')->nullable()->default(null);
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_blocktranslation', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('BlockId', 40);
            $table->string('Language', 2)->default('en');
            $table->text('Content')->nullable();
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_widget', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('ParentId', 40)->nullable()->default('');
            $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
            $table->string('Type', 40)->nullable()->default(null);
            $table->string('Title', 255);
            $table->integer('Sequence')->nullable()->default(null);
            $table->integer('Cache')->nullable()->default(null);
            $table->text('Parameters')->nullable()->default(null);
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_menu', function ($table) {
            $table->string('Id', 40)->primary();
            $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
            $table->string('Title', 255)->nullable()->default('');
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_menuitem', function ($table) {
            $table->string('Id', 40)->primary();
            $table->enum('Status', ['Draft', 'Published', 'Unpublished', 'Deleted'])->default('Draft');
            $table->string('MenuId', 40);
            $table->string('ParentId', 40)->nullable()->default('');
            $table->string('Sequence', 40)->nullable()->default('');
            $table->string('Title', 255)->nullable()->default('');
            $table->string('Url', 510)->nullable()->default('');
            $table->string('PageId', 40)->nullable()->default('');
            $table->string('Target', 20)->nullable()->default('');
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_version', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('EntityType', 20)->nullable()->default(null);
            $table->string('EntityId', 20);
            $table->longText('Data')->nullable()->default(null);
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_translation_key', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('Key', 255)->index();
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });

        \Schema::connection('testing')->create('snv_cms_translation_value', function ($table) {
            $table->string('Id', 40)->primary();
            $table->string('KeyId', 40)->index();
            $table->string('Language', 2)->index();
            $table->text('Value')->nullable()->default(null);
            $table->datetime('CreatedAt')->nullable()->default(null);
            $table->datetime('UpdatedAt')->nullable()->default(null);
            $table->datetime('DeletedAt')->nullable()->default(null);
        });
    }
}
