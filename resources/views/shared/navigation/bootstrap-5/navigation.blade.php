<div class="card card-default" style="margin-bottom: 10px;">
    <div class="card-body" style="padding: 2px;">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateManager(); ?>">
                    Templates
                    <span class="badge bg-secondary"><?php echo $templateCount; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">
                    Pages
                    <span class="badge bg-secondary"><?php echo $pageCount; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">
                    Blocks
                    <span class="badge bg-secondary"><?php echo $blockCount; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetManager(); ?>">
                    Widgets
                    <span class="badge bg-secondary"><?php echo $widgetCount; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationManager(); ?>">
                    Translations
                    <span class="badge bg-secondary"><?php echo $translationCount; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo \Sinevia\Cms\Helpers\Links::adminMediaManager(); ?>" target="_blank">
                    Media
                </a>
            </li>
        </ul>
    </div>
</div>
