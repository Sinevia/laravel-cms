<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\Widget;
use Sinevia\Cms\Tests\TestCase;

class WidgetTest extends TestCase
{
    public function test_widget_can_be_created(): void
    {
        $widget = new Widget();
        $widget->Id = 'test-widget-id-00001';
        $widget->Status = 'Draft';
        $widget->Title = 'Test Widget';
        $widget->Type = 'contact_form';
        $widget->save();

        $this->assertDatabaseHas('snv_cms_widget', [
            'Id' => 'test-widget-id-00001',
            'Status' => 'Draft',
            'Title' => 'Test Widget',
            'Type' => 'contact_form',
        ]);
    }

    public function test_widget_can_be_found_by_id(): void
    {
        $widget = new Widget();
        $widget->Id = 'find-widget-id-000001';
        $widget->Status = 'Published';
        $widget->Title = 'Find Me Widget';
        $widget->Type = 'map';
        $widget->save();

        $found = Widget::find('find-widget-id-000001');
        $this->assertNotNull($found);
        $this->assertEquals('Find Me Widget', $found->Title);
    }

    public function test_widget_render_returns_empty_for_unpublished_widget(): void
    {
        $widget = new Widget();
        $widget->Id = 'widget-unpublished-01';
        $widget->Status = 'Draft';
        $widget->Title = 'Draft Widget';
        $widget->Type = 'test';
        $widget->save();

        $this->assertEquals('', $widget->render());
    }

    public function test_widget_render_widget_returns_empty_for_missing_widget(): void
    {
        $this->assertEquals('', Widget::renderWidget('nonexistent-widget-id'));
    }

    public function test_widget_render_widgets_replaces_shortcodes(): void
    {
        $widget = new Widget();
        $widget->Id = 'widget-shortcode-00001';
        $widget->Status = 'Published';
        $widget->Title = 'Shortcode Widget';
        $widget->Type = 'test_widget';
        $widget->Parameters = json_encode(['message' => 'Hello Widget']);
        $widget->save();

        $widgetsPath = config('cms.paths.widgets', 'widgets');
        $widgetDir = resource_path($widgetsPath . '/test_widget');
        @mkdir($widgetDir, 0777, true);
        file_put_contents($widgetDir . '/template.phtml', '<p>{$message}</p>');

        $string = 'Before [[WIDGET_' . $widget->Id . ']] After';
        $result = Widget::renderWidgets($string);

        $this->assertStringContainsString('Hello Widget', $result);
        $this->assertStringNotContainsString('[[WIDGET_', $result);

        unlink($widgetDir . '/template.phtml');
        rmdir($widgetDir);
    }

    public function test_widget_render_widgets_leaves_string_unchanged_without_shortcodes(): void
    {
        $string = '<p>No widget shortcodes here</p>';
        $this->assertEquals($string, Widget::renderWidgets($string));
    }

    public function test_widget_path_returns_empty_when_widgets_path_not_configured(): void
    {
        config()->set('cms.paths.widgets', '');
        $this->assertEquals('', Widget::path('test'));
    }

    public function test_widget_path_returns_full_path_when_configured(): void
    {
        config()->set('cms.paths.widgets', 'widgets');
        $path = Widget::path('contact_form');
        $this->assertStringContainsString('widgets', $path);
        $this->assertStringContainsString('contact_form', $path);
    }
}
