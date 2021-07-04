<section class="content-header">
    <h1>
        Edit Template: <?php echo $template->Title; ?>
        <small>(#<?php echo $template->Id; ?>)</small>
    </h1>
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
                <i class="fa fa-dashboard"></i>
                Home
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateManager(); ?>">
                CMS
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateManager(); ?>">
                Templates
            </a>
        </li>
        <li class="breadcrumb-item active">
            Edit Template
        </li>
    </ol>
</section>
