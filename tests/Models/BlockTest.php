<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\Block;
use Sinevia\Cms\Models\BlockTranslation;
use Sinevia\Cms\Tests\TestCase;

class BlockTest extends TestCase
{
    public function test_block_can_be_created(): void
    {
        $block = new Block();
        $block->Id = 'test-block-id-00001';
        $block->Status = 'Draft';
        $block->Title = 'Test Block';
        $block->save();

        $this->assertDatabaseHas('snv_cms_block', [
            'Id' => 'test-block-id-00001',
            'Status' => 'Draft',
            'Title' => 'Test Block',
        ]);
    }

    public function test_block_can_be_found_by_id(): void
    {
        $block = new Block();
        $block->Id = 'find-block-id-000001';
        $block->Status = 'Published';
        $block->Title = 'Find Me Block';
        $block->save();

        $found = Block::find('find-block-id-000001');
        $this->assertNotNull($found);
        $this->assertEquals('Find Me Block', $found->Title);
    }

    public function test_block_translations_relationship(): void
    {
        $block = new Block();
        $block->Id = 'block-trans-rel-00001';
        $block->Status = 'Published';
        $block->Title = 'Translated Block';
        $block->save();

        $translation = new BlockTranslation();
        $translation->Id = 'block-trans-id-000001';
        $translation->BlockId = $block->Id;
        $translation->Language = 'en';
        $translation->Content = '<p>Block content</p>';
        $translation->save();

        $this->assertCount(1, $block->translations);
        $this->assertEquals('<p>Block content</p>', $block->translations->first()->Content);
    }

    public function test_block_translation_method_returns_translation_for_language(): void
    {
        $block = new Block();
        $block->Id = 'block-trans-method-001';
        $block->Status = 'Published';
        $block->Title = 'Block With Translation';
        $block->save();

        $translation = new BlockTranslation();
        $translation->Id = 'block-trans-meth-0001';
        $translation->BlockId = $block->Id;
        $translation->Language = 'en';
        $translation->Content = '<p>English Block</p>';
        $translation->save();

        $enTranslation = $block->translation('en');
        $this->assertNotNull($enTranslation);
        $this->assertEquals('<p>English Block</p>', $enTranslation->Content);
    }

    public function test_block_translation_returns_null_for_missing_language(): void
    {
        $block = new Block();
        $block->Id = 'block-no-trans-000001';
        $block->Status = 'Published';
        $block->Title = 'No Translation Block';
        $block->save();

        $this->assertNull($block->translation('fr'));
    }

    public function test_block_render_returns_empty_for_unpublished_block(): void
    {
        $block = new Block();
        $block->Id = 'block-unpublished-001';
        $block->Status = 'Draft';
        $block->Title = 'Draft Block';
        $block->save();

        $translation = new BlockTranslation();
        $translation->Id = 'block-unpub-trans-001';
        $translation->BlockId = $block->Id;
        $translation->Language = 'en';
        $translation->Content = '<p>Should not render</p>';
        $translation->save();

        $this->assertEquals('', $block->render());
    }

    public function test_block_render_block_returns_empty_for_missing_block(): void
    {
        $this->assertEquals('', Block::renderBlock('nonexistent-block-id'));
    }

    public function test_block_render_blocks_replaces_shortcodes(): void
    {
        $block = new Block();
        $block->Id = 'block-shortcode-000001';
        $block->Status = 'Published';
        $block->Title = 'Shortcode Block';
        $block->save();

        $translation = new BlockTranslation();
        $translation->Id = 'block-shortcode-tr-001';
        $translation->BlockId = $block->Id;
        $translation->Language = 'en';
        $translation->Content = '<p>Rendered block content</p>';
        $translation->save();

        $string = 'Before [[BLOCK_' . $block->Id . ']] After';
        $result = Block::renderBlocks($string);

        $this->assertStringContainsString('Rendered block content', $result);
        $this->assertStringNotContainsString('[[BLOCK_', $result);
    }

    public function test_block_render_blocks_leaves_string_unchanged_without_shortcodes(): void
    {
        $string = '<p>No shortcodes here</p>';
        $this->assertEquals($string, Block::renderBlocks($string));
    }

    public function test_block_create_version_returns_true(): void
    {
        $block = new Block();
        $block->Id = 'block-version-000001';
        $block->Status = 'Published';
        $block->Title = 'Versioned Block';
        $block->save();

        $result = $block->createVersion();
        $this->assertTrue($result);
    }
}
