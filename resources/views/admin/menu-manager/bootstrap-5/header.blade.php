<h1>
    Menu Manager
    <button type="button" class="btn btn-primary float-end" onclick="showMenuCreateModal();">
        @include("cms::shared.icons.bootstrap.bi-plus-circle")
        Add Menu
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
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuManager(); ?>">CMS</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuManager(); ?>">Menus</a>
    </li>
</ol>
