<h1>
    Page Manager
    <button type="button" class="btn btn-primary float-end" onclick="showPageCreateModal();">
        <span class="fa fa-plus-circle"></span>
        Add Page
    </button>
</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            <i class="fa fa-dashboard"></i>
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
