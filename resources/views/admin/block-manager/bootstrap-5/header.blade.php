<h1>
    Block Manager
    <button type="button" class="btn btn-primary pull-right" onclick="showBlockCreateModal();">
        <span class="glyphicon glyphicon-plus-sign"></span>
        Add Block
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
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">CMS</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">Blocks</a>
    </li>
</ol>
