<h1>
    Widget Manager
    
    <button type="button" class="btn btn-primary pull-right" onclick="showWidgetCreateModal();">
        @include("cms::shared.icons.bootstrap.bi-plus-circle")
        Add Widget
    </button>
</h1>

<ol class="breadcrumb">    
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            @include("cms::shared.icons.bootstrap.bi-house")
            Home
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            CMS
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetManager(); ?>">
            Widgets
        </a>
    </li>
</ol>
