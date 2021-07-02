<?php
$blockCount = \Sinevia\Cms\Models\Block::where('Status', '<>', 'Deleted')->count();
$pageCount = \Sinevia\Cms\Models\Page::where('Status', '<>', 'Deleted')->count();
$templateCount = \Sinevia\Cms\Models\Template::where('Status', '<>', 'Deleted')->count();
$translationCount = \Sinevia\Cms\Models\TranslationValue::count();
$widgetCount = \Sinevia\Cms\Models\Widget::where('Status', '<>', 'Deleted')->count();
?>
<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::shared/navigation/bootstrap-5/navigation')
<?php } else { ?>
    @include('cms::shared/navigation/bootstrap-4/navigation')
<?php } ?>
