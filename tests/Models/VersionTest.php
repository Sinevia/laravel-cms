<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\Version;
use Sinevia\Cms\Tests\TestCase;

class VersionTest extends TestCase
{
    public function test_version_can_be_created(): void
    {
        $version = new Version();
        $version->Id = 'test-version-id-0001';
        $version->EntityType = 'CmsPage';
        $version->EntityId = 'some-page-id';
        $version->Data = json_encode(['title' => 'Test']);
        $version->save();

        $this->assertDatabaseHas('snv_cms_version', [
            'Id' => 'test-version-id-0001',
            'EntityType' => 'CmsPage',
            'EntityId' => 'some-page-id',
        ]);
    }

    public function test_get_data_returns_decoded_json(): void
    {
        $version = new Version();
        $version->Id = 'version-data-0000001';
        $version->EntityType = 'CmsPage';
        $version->EntityId = 'page-id';
        $version->Data = json_encode(['title' => 'My Page', 'status' => 'Published']);
        $version->save();

        $data = $version->getData();
        $this->assertIsArray($data);
        $this->assertEquals('My Page', $data['title']);
        $this->assertEquals('Published', $data['status']);
    }

    public function test_get_data_returns_null_for_invalid_json(): void
    {
        $version = new Version();
        $version->Id = 'version-bad-json-0001';
        $version->EntityType = 'CmsPage';
        $version->EntityId = 'page-id';
        $version->Data = 'not valid json{{{';
        $version->save();

        $this->assertNull($version->getData());
    }

    public function test_create_version_stores_data_as_json(): void
    {
        $version = Version::createVersion('CmsBlock', 'block-id-123', [
            'title' => 'Block Title',
            'content' => '<p>Content</p>',
        ]);

        $this->assertNotNull($version);
        $this->assertEquals('CmsBlock', $version->EntityType);
        $this->assertEquals('block-id-123', $version->EntityId);

        $data = $version->getData();
        $this->assertEquals('Block Title', $data['title']);
        $this->assertEquals('<p>Content</p>', $data['content']);
    }

    public function test_find_versions_returns_versions_for_entity(): void
    {
        Version::createVersion('CmsPage', 'page-find-001', ['v' => 1]);
        Version::createVersion('CmsPage', 'page-find-001', ['v' => 2]);
        Version::createVersion('CmsPage', 'page-find-002', ['v' => 3]);

        $versions = Version::findVersions('page-find-001');
        $this->assertCount(2, $versions);
    }

    public function test_find_versions_filters_by_entity_type(): void
    {
        Version::createVersion('CmsPage', 'entity-001', ['v' => 1]);
        Version::createVersion('CmsTemplate', 'entity-001', ['v' => 2]);

        $pageVersions = Version::findVersions('entity-001', 'CmsPage');
        $this->assertCount(1, $pageVersions);
        $this->assertEquals('CmsPage', $pageVersions->first()->EntityType);
    }

    public function test_find_versions_returns_empty_for_nonexistent_entity(): void
    {
        $versions = Version::findVersions('nonexistent-entity');
        $this->assertCount(0, $versions);
    }
}
