<section class="content-header">
    <h1>
        Edit Translation: <?php echo $translationKey->Title; ?>
        <small>(#<?php echo $translationKey->Id; ?>)</small>
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
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationManager(); ?>">
                Translations
            </a>
        </li>
        <li class="breadcrumb-item active">
            Edit Translation
        </li>
    </ol>
</section>
