<h1>
    Page Manager
    <button type="button" class="btn btn-primary float-end" onclick="showPageCreateModal();">
        @include("cms::shared.icons.bootstrap.bi-plus-circle")
        Add Page
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
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">CMS</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">Pages</a>
    </li>
</ol>
