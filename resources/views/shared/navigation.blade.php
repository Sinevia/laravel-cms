<?php
$blockCount = \Sinevia\Cms\Models\Block::where('Status', '<>', 'Deleted')->count();
$pageCount = \Sinevia\Cms\Models\Page::where('Status', '<>', 'Deleted')->count();
$templateCount = \Sinevia\Cms\Models\Template::where('Status', '<>', 'Deleted')->count();
$widgetCount = \Sinevia\Cms\Models\Widget::where('Status', '<>', 'Deleted')->count();
?>
<div class="panel panel-default">
    <div class="panel-body" style="padding: 2px;">
        <ul class="nav nav-pills">
            <li>
                <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">Dashboard</a>
            </li>
            <li>
                <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateManager(); ?>">
                    Templates
                    <span class="badge"><?php echo $templateCount; ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">
                    Pages
                    <span class="badge"><?php echo $pageCount; ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">
                    Blocks
                    <span class="badge"><?php echo $blockCount; ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetManager(); ?>">
                    Widget
                    <span class="badge"><?php echo $widgetCount; ?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMediaManager(); ?>" target="_blank">
                    Media
                </a>
            </li>
        </ul>
    </div>
</div>