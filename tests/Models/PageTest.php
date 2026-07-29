<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\Page;
use Sinevia\Cms\Models\PageTranslation;
use Sinevia\Cms\Tests\TestCase;

class PageTest extends TestCase
{
    public function test_page_can_be_created(): void
    {
        $page = new Page();
        $page->Id = 'test-page-id-001';
        $page->Status = 'Draft';
        $page->Alias = '/test-page';
        $page->save();

        $this->assertDatabaseHas('snv_cms_page', [
            'Id' => 'test-page-id-001',
            'Status' => 'Draft',
            'Alias' => '/test-page',
        ]);
    }

    public function test_page_can_be_found_by_id(): void
    {
        $page = new Page();
        $page->Id = 'find-me-page-001';
        $page->Status = 'Published';
        $page->Alias = '/find-me';
        $page->save();

        $found = Page::find('find-me-page-001');
        $this->assertNotNull($found);
        $this->assertEquals('Published', $found->Status);
        $this->assertEquals('/find-me', $found->Alias);
    }

    public function test_page_translations_relationship(): void
    {
        $page = new Page();
        $page->Id = 'page-with-trans-001';
        $page->Status = 'Published';
        $page->Alias = '/translated-page';
        $page->save();

        $translation = new PageTranslation();
        $translation->Id = 'page-trans-id-0001';
        $translation->PageId = $page->Id;
        $translation->Language = 'en';
        $translation->Title = 'Hello World';
        $translation->Content = '<p>Welcome</p>';
        $translation->save();

        $this->assertCount(1, $page->translations);
        $this->assertEquals('Hello World', $page->translations->first()->Title);
    }

    public function test_page_translation_method_returns_translation_for_language(): void
    {
        $page = new Page();
        $page->Id = 'page-trans-method-01';
        $page->Status = 'Published';
        $page->Alias = '/trans-method';
        $page->save();

        $translation = new PageTranslation();
        $translation->Id = 'page-trans-meth-0001';
        $translation->PageId = $page->Id;
        $translation->Language = 'en';
        $translation->Title = 'English Title';
        $translation->Content = 'English Content';
        $translation->save();

        $enTranslation = $page->translation('en');
        $this->assertNotNull($enTranslation);
        $this->assertEquals('English Title', $enTranslation->Title);
    }

    public function test_page_translation_returns_null_for_missing_language(): void
    {
        $page = new Page();
        $page->Id = 'page-no-trans-000001';
        $page->Status = 'Published';
        $page->Alias = '/no-translation';
        $page->save();

        $this->assertNull($page->translation('fr'));
    }

    public function test_page_get_title_returns_translation_title(): void
    {
        $page = new Page();
        $page->Id = 'page-get-title-00001';
        $page->Status = 'Published';
        $page->Alias = '/get-title';
        $page->save();

        $translation = new PageTranslation();
        $translation->Id = 'page-title-trans-001';
        $translation->PageId = $page->Id;
        $translation->Language = 'en';
        $translation->Title = 'My Page Title';
        $translation->save();

        $this->assertEquals('My Page Title', $page->getTitle('en'));
    }

    public function test_page_get_title_returns_empty_string_for_missing_translation(): void
    {
        $page = new Page();
        $page->Id = 'page-empty-title-001';
        $page->Status = 'Published';
        $page->Alias = '/empty-title';
        $page->save();

        $this->assertEquals('', $page->getTitle('en'));
    }

    public function test_page_get_content_returns_translation_content(): void
    {
        $page = new Page();
        $page->Id = 'page-get-content-001';
        $page->Status = 'Published';
        $page->Alias = '/get-content';
        $page->save();

        $translation = new PageTranslation();
        $translation->Id = 'page-content-tr-001';
        $translation->PageId = $page->Id;
        $translation->Language = 'en';
        $translation->Title = 'Content Test';
        $translation->Content = '<p>Hello Content</p>';
        $translation->save();

        $this->assertEquals('<p>Hello Content</p>', $page->getContent('en'));
    }

    public function test_page_get_content_returns_empty_string_for_missing_translation(): void
    {
        $page = new Page();
        $page->Id = 'page-no-content-0001';
        $page->Status = 'Published';
        $page->Alias = '/no-content';
        $page->save();

        $this->assertEquals('', $page->getContent('en'));
    }

    public function test_page_get_url_returns_not_found_for_missing_page(): void
    {
        $url = Page::getUrl('nonexistent-page-id');
        $this->assertStringContainsString('page-notfound', $url);
    }

    public function test_page_create_version_returns_true(): void
    {
        $page = new Page();
        $page->Id = 'page-version-000001';
        $page->Status = 'Published';
        $page->Alias = '/versioned-page';
        $page->save();

        $result = $page->createVersion();
        $this->assertTrue($result);
    }

    public function test_page_default_status_is_draft(): void
    {
        $page = new Page();
        $page->Id = 'page-default-status-1';
        $page->save();

        $found = Page::find('page-default-status-1');
        $this->assertEquals('Draft', $found->Status);
    }

    public function test_page_default_access_is_public(): void
    {
        $page = new Page();
        $page->Id = 'page-default-access-1';
        $page->save();

        $found = Page::find('page-default-access-1');
        $this->assertEquals('Public', $found->Access);
    }
}
