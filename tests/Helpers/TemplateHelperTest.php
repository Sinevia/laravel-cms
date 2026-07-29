<?php

namespace Sinevia\Cms\Tests\Helpers;

use Sinevia\Cms\Helpers\Template;
use Sinevia\Cms\Tests\TestCase;

class TemplateHelperTest extends TestCase
{
    public function test_from_string_with_no_variables_returns_unchanged(): void
    {
        $result = Template::fromString('<h1>Hello World</h1>');
        $this->assertStringContainsString('<h1>Hello World</h1>', $result);
    }

    public function test_from_string_replaces_dollar_variable_syntax(): void
    {
        $result = Template::fromString('Hello, {$name}!', ['name' => 'John']);
        $this->assertStringContainsString('Hello, John!', $result);
    }

    public function test_from_string_replaces_nested_array_variables(): void
    {
        $result = Template::fromString('City: {$address_city}', [
            'address' => ['city' => 'London'],
        ]);
        $this->assertStringContainsString('City: London', $result);
    }

    public function test_from_string_evaluates_php_code(): void
    {
        $result = Template::fromString('<?php echo "Dynamic"; ?>');
        $this->assertStringContainsString('Dynamic', $result);
    }

    public function test_from_string_with_empty_string_returns_empty(): void
    {
        $result = Template::fromString('');
        $this->assertEquals('', $result);
    }

    public function test_from_string_handles_multiple_variables(): void
    {
        $result = Template::fromString(
            '{$greeting}, {$name}! Today is {$day}.',
            ['greeting' => 'Hi', 'name' => 'Alice', 'day' => 'Monday']
        );
        $this->assertStringContainsString('Hi, Alice! Today is Monday.', $result);
    }

    public function test_from_file_returns_content_for_existing_file(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'tmpl_') . '.phtml';
        file_put_contents($tempFile, '<p>{$message}</p>');

        $result = Template::fromFile($tempFile, ['message' => 'Loaded from file']);
        $this->assertStringContainsString('Loaded from file', $result);

        unlink($tempFile);
    }

    public function test_minify_html_removes_comments(): void
    {
        $html = "<div><!-- comment --><p>Hello</p></div>";
        $result = Template::minifyHtml($html);
        $this->assertStringNotContainsString('<!-- comment -->', $result);
        $this->assertStringContainsString('Hello', $result);
    }

    public function test_minify_html_removes_extra_whitespace(): void
    {
        $html = "<div>   <p>Hello</p>   </div>";
        $result = Template::minifyHtml($html);
        $this->assertStringContainsString('<div> <p>Hello</p> </div>', $result);
    }

    public function test_minify_css_removes_comments_and_whitespace(): void
    {
        $css = "/* comment */ body { color : red ; margin : 0 ; }";
        $result = Template::minifyCss([$css]);
        $this->assertStringNotContainsString('/* comment */', $result);
        $this->assertStringContainsString('color', $result);
        $this->assertStringContainsString('red', $result);
    }
}
