<h1>
    Edit Widget: <?php echo $widget->Title; ?>
    <small>(#<?php echo $widget->Id; ?>)</small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            <i class="fa fa-dashboard"></i> 
            Home
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            CMS
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetManager(); ?>">
            Widgets
        </a>
    </li>
    <li class="breadcrumb-item active">
        Edit Widget
    </li>
</ol>
