<h1>
    Translation Manager
    
    <button type="button" class="btn btn-primary pull-right" onclick="showTranslationCreateModal();">
        @include("cms::shared.icons.bootstrap.bi-plus-circle")
        Add Translation
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
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationManager(); ?>">
            CMS
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationManager(); ?>">
            Translations
        </a>
    </li>
</ol>
