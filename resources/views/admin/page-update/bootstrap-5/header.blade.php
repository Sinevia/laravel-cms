<h1>
    Edit Page: <?php echo $page->Title; ?>
    <small>(<?php echo $page->Status; ?>)</small>
</h1>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            @include("cms::shared.icons.bootstrap.bi-house")
            Home
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>">
            CMS
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">
            Pages
        </a>
    </li>
    <li class="breadcrumb-item active">
        Edit Page
    </li>
</ol>
