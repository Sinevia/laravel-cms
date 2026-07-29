<?php

namespace Sinevia\Cms\Tests\Helpers;

use Sinevia\Cms\Helpers\Languages;
use Sinevia\Cms\Tests\TestCase;

class LanguagesTest extends TestCase
{
    public function test_data_is_non_empty_array(): void
    {
        $this->assertIsArray(Languages::$data);
        $this->assertNotEmpty(Languages::$data);
    }

    public function test_data_contains_english(): void
    {
        $codes = array_column(Languages::$data, 0);
        $this->assertContains('en', $codes);
    }

    public function test_data_contains_french(): void
    {
        $codes = array_column(Languages::$data, 0);
        $this->assertContains('fr', $codes);
    }

    public function test_data_contains_german(): void
    {
        $codes = array_column(Languages::$data, 0);
        $this->assertContains('de', $codes);
    }

    public function test_data_contains_spanish(): void
    {
        $codes = array_column(Languages::$data, 0);
        $this->assertContains('es', $codes);
    }

    public function test_each_entry_has_code_and_name(): void
    {
        foreach (Languages::$data as $entry) {
            $this->assertCount(2, $entry);
            $this->assertNotEmpty($entry[0]);
            $this->assertNotEmpty($entry[1]);
        }
    }

    public function test_language_codes_are_two_chars(): void
    {
        foreach (Languages::$data as $entry) {
            $this->assertEquals(2, strlen($entry[0]));
        }
    }
}
