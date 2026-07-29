<?php

namespace Sinevia\Cms\Tests\Helpers;

use Sinevia\Cms\Helpers\CmsHelper;
use Sinevia\Cms\Tests\TestCase;

class CmsHelperTest extends TestCase
{
    public function test_auth_returns_json_with_authenticate_status(): void
    {
        $result = CmsHelper::auth('Please log in');

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals('authenticate', $decoded['status']);
        $this->assertEquals('Please log in', $decoded['message']);
    }

    public function test_error_returns_json_with_error_status(): void
    {
        $result = CmsHelper::error('Something went wrong');

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals('error', $decoded['status']);
        $this->assertEquals('Something went wrong', $decoded['message']);
    }

    public function test_success_returns_json_with_success_status(): void
    {
        $result = CmsHelper::success('All good');

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals('success', $decoded['status']);
        $this->assertEquals('All good', $decoded['message']);
    }

    public function test_success_includes_data_array(): void
    {
        $result = CmsHelper::success('OK', ['id' => 42]);

        $decoded = json_decode($result, true);
        $this->assertEquals(['id' => 42], $decoded['data']);
    }

    public function test_error_includes_data_array(): void
    {
        $result = CmsHelper::error('Bad', ['code' => 500]);

        $decoded = json_decode($result, true);
        $this->assertEquals(['code' => 500], $decoded['data']);
    }

    public function test_array_to_html_attributes_with_empty_array_returns_empty_string(): void
    {
        $this->assertEquals('', CmsHelper::arrayToHtmlAttributes([]));
    }

    public function test_array_to_html_attributes_with_single_attribute(): void
    {
        $result = CmsHelper::arrayToHtmlAttributes(['class' => 'btn']);
        $this->assertStringContainsString('class="btn"', $result);
    }

    public function test_array_to_html_attributes_with_multiple_attributes(): void
    {
        $result = CmsHelper::arrayToHtmlAttributes(['class' => 'btn', 'id' => 'submit']);
        $this->assertStringContainsString('class="btn"', $result);
        $this->assertStringContainsString('id="submit"', $result);
    }

    public function test_array_to_html_attributes_escapes_quotes(): void
    {
        $result = CmsHelper::arrayToHtmlAttributes(['title' => 'Say "hello"']);
        $this->assertStringContainsString('Say', $result);
        $this->assertStringContainsString('\"hello\"', $result);
    }

    public function test_blade_renders_simple_blade_echo(): void
    {
        $result = CmsHelper::blade('Hello, {{ $name }}!', ['name' => 'World']);
        $this->assertEquals('Hello, World!', $result);
    }

    public function test_blade_renders_triple_curly(): void
    {
        $result = CmsHelper::blade('Hello, {{{ $name }}}!', ['name' => '<b>World</b>']);
        $this->assertStringContainsString('World', $result);
    }

    public function test_blade_renders_php_directive(): void
    {
        $result = CmsHelper::blade('@php($x = 5){{ $x }}');
        $this->assertEquals('5', $result);
    }

    public function test_blade_with_empty_string_returns_empty(): void
    {
        $this->assertEquals('', CmsHelper::blade(''));
    }
}
