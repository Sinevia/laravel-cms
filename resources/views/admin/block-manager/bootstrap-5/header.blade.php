<h1>
    Block Manager
    
    <button type="button" class="btn btn-primary pull-right" onclick="showBlockCreateModal();">
        @include("cms::shared.icons.bootstrap.bi-plus-circle")
        Add Block
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
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">CMS</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">Blocks</a>
    </li>
</ol>
