<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\Template;
use Sinevia\Cms\Models\TemplateTranslation;
use Sinevia\Cms\Tests\TestCase;

class TemplateModelTest extends TestCase
{
    public function test_template_can_be_created(): void
    {
        $template = new Template();
        $template->Id = 'test-template-id-001';
        $template->Status = 'Draft';
        $template->Title = 'Test Template';
        $template->save();

        $this->assertDatabaseHas('snv_cms_template', [
            'Id' => 'test-template-id-001',
            'Status' => 'Draft',
            'Title' => 'Test Template',
        ]);
    }

    public function test_template_can_be_found_by_id(): void
    {
        $template = new Template();
        $template->Id = 'find-template-id-001';
        $template->Status = 'Published';
        $template->Title = 'Find Me Template';
        $template->save();

        $found = Template::find('find-template-id-001');
        $this->assertNotNull($found);
        $this->assertEquals('Find Me Template', $found->Title);
    }

    public function test_template_translations_relationship(): void
    {
        $template = new Template();
        $template->Id = 'tmpl-trans-rel-000001';
        $template->Status = 'Published';
        $template->Title = 'Translated Template';
        $template->save();

        $translation = new TemplateTranslation();
        $translation->Id = 'tmpl-trans-id-000001';
        $translation->TemplateId = $template->Id;
        $translation->Language = 'en';
        $translation->Content = '<html>{$page_content}</html>';
        $translation->save();

        $this->assertCount(1, $template->translations);
        $this->assertEquals('<html>{$page_content}</html>', $template->translations->first()->Content);
    }

    public function test_template_translation_method_returns_translation_for_language(): void
    {
        $template = new Template();
        $template->Id = 'tmpl-trans-method-001';
        $template->Status = 'Published';
        $template->Title = 'Template With Translation';
        $template->save();

        $translation = new TemplateTranslation();
        $translation->Id = 'tmpl-trans-meth-0001';
        $translation->TemplateId = $template->Id;
        $translation->Language = 'en';
        $translation->Content = '<div>{$page_title}</div>';
        $translation->save();

        $enTranslation = $template->translation('en');
        $this->assertNotNull($enTranslation);
        $this->assertEquals('<div>{$page_title}</div>', $enTranslation->Content);
    }

    public function test_template_translation_returns_null_for_missing_language(): void
    {
        $template = new Template();
        $template->Id = 'tmpl-no-trans-000001';
        $template->Status = 'Published';
        $template->Title = 'No Translation Template';
        $template->save();

        $this->assertNull($template->translation('fr'));
    }

    public function test_template_render_processes_variables(): void
    {
        $template = new Template();
        $template->Id = 'tmpl-render-00000001';
        $template->Status = 'Published';
        $template->Title = 'Renderable Template';
        $template->save();

        $translation = new TemplateTranslation();
        $translation->Id = 'tmpl-render-tr-000001';
        $translation->TemplateId = $template->Id;
        $translation->Language = 'en';
        $translation->Content = '<h1>{$page_title}</h1><div>{$page_content}</div>';
        $translation->save();

        $rendered = $template->render('en', [
            'page_title' => 'My Title',
            'page_content' => 'My Content',
        ]);

        $this->assertStringContainsString('My Title', $rendered);
        $this->assertStringContainsString('My Content', $rendered);
    }

    public function test_template_render_embeds_blocks(): void
    {
        $block = new \Sinevia\Cms\Models\Block();
        $block->Id = 'tmpl-block-000000001';
        $block->Status = 'Published';
        $block->Title = 'Embedded Block';
        $block->save();

        $blockTranslation = new \Sinevia\Cms\Models\BlockTranslation();
        $blockTranslation->Id = 'tmpl-block-tr-0000001';
        $blockTranslation->BlockId = $block->Id;
        $blockTranslation->Language = 'en';
        $blockTranslation->Content = '<p>Block in template</p>';
        $blockTranslation->save();

        $template = new Template();
        $template->Id = 'tmpl-with-block-00001';
        $template->Status = 'Published';
        $template->Title = 'Template With Block';
        $template->save();

        $translation = new TemplateTranslation();
        $translation->Id = 'tmpl-with-block-tr-001';
        $translation->TemplateId = $template->Id;
        $translation->Language = 'en';
        $translation->Content = '<div>[[BLOCK_' . $block->Id . ']]</div>';
        $translation->save();

        $rendered = $template->render('en', []);
        $this->assertStringContainsString('Block in template', $rendered);
        $this->assertStringNotContainsString('[[BLOCK_', $rendered);
    }

    public function test_template_create_version_returns_true(): void
    {
        $template = new Template();
        $template->Id = 'tmpl-version-00000001';
        $template->Status = 'Published';
        $template->Title = 'Versioned Template';
        $template->save();

        $result = $template->createVersion();
        $this->assertTrue($result);
    }
}
