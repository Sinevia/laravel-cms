<h1>
    Template Manager
    
    <button type="button" class="btn btn-primary pull-right" onclick="showTemplateCreateModal();">
        @include("cms::shared.icons.bootstrap.bi-plus-circle")
        Add Template
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
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateManager(); ?>">
            CMS
        </a>
    </li>
    <li class="breadcrumb-item active">
        Templates
    </li>
</ol>
