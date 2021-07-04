<section class="content-header">
    <h1>
        Edit Block: <?php echo $block->Title; ?>
        <small>(#<?php echo $block->Id; ?>)</small>
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
        <li class="breadcrumb-item">
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockManager(); ?>">Blocks</a>
        </li>
        <li class="breadcrumb-item active">
            Edit Block
        </li>
    </ol>
</section>
