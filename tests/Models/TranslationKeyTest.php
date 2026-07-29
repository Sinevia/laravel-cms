<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\TranslationKey;
use Sinevia\Cms\Models\TranslationValue;
use Sinevia\Cms\Tests\TestCase;

class TranslationKeyTest extends TestCase
{
    public function test_translation_key_can_be_created(): void
    {
        $key = new TranslationKey();
        $key->Id = 'trans-key-id-0000001';
        $key->Key = 'welcome_message';
        $key->save();

        $this->assertDatabaseHas('snv_cms_translation_key', [
            'Id' => 'trans-key-id-0000001',
            'Key' => 'welcome_message',
        ]);
    }

    public function test_translate_returns_value_for_existing_key_and_language(): void
    {
        $key = new TranslationKey();
        $key->Id = 'trans-key-en-0000001';
        $key->Key = 'greeting';
        $key->save();

        $value = new TranslationValue();
        $value->Id = 'trans-value-en-000001';
        $value->KeyId = $key->Id;
        $value->Language = 'en';
        $value->Value = 'Hello!';
        $value->save();

        $this->assertEquals('Hello!', TranslationKey::translate('greeting', 'en'));
    }

    public function test_translate_returns_na_for_missing_key(): void
    {
        $this->assertEquals('n/a', TranslationKey::translate('nonexistent_key', 'en'));
    }

    public function test_translate_returns_key_placeholder_for_missing_value(): void
    {
        $key = new TranslationKey();
        $key->Id = 'trans-key-no-val-0001';
        $key->Key = 'no_value_key';
        $key->save();

        $result = TranslationKey::translate('no_value_key', 'en');
        $this->assertStringContainsString('no_value_key', $result);
        $this->assertStringContainsString('n/a', $result);
    }

    public function test_translate_falls_back_to_english_for_missing_language(): void
    {
        $key = new TranslationKey();
        $key->Id = 'trans-key-fallback-001';
        $key->Key = 'fallback_key';
        $key->save();

        $enValue = new TranslationValue();
        $enValue->Id = 'trans-val-en-fallback1';
        $enValue->KeyId = $key->Id;
        $enValue->Language = 'en';
        $enValue->Value = 'English Fallback';
        $enValue->save();

        $this->assertEquals('English Fallback', TranslationKey::translate('fallback_key', 'fr'));
    }

    public function test_translate_returns_different_values_for_different_languages(): void
    {
        $key = new TranslationKey();
        $key->Id = 'trans-key-multi-lang-01';
        $key->Key = 'goodbye';
        $key->save();

        $enValue = new TranslationValue();
        $enValue->Id = 'trans-val-multi-en-001';
        $enValue->KeyId = $key->Id;
        $enValue->Language = 'en';
        $enValue->Value = 'Goodbye';
        $enValue->save();

        $frValue = new TranslationValue();
        $frValue->Id = 'trans-val-multi-fr-001';
        $frValue->KeyId = $key->Id;
        $frValue->Language = 'fr';
        $frValue->Value = 'Au revoir';
        $frValue->save();

        $this->assertEquals('Goodbye', TranslationKey::translate('goodbye', 'en'));
        $this->assertEquals('Au revoir', TranslationKey::translate('goodbye', 'fr'));
    }
}
