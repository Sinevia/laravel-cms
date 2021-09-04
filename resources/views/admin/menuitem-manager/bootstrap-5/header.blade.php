<h1>
    Edit Menu Items for Menu: 
    {{ $menu->Title }}    
    <small>(<?php echo $menu->Status; ?>)</small>
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
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuManager(); ?>">Menus</a>
    </li>    
    <li class="breadcrumb-item">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuManager(); ?>">Menu: <b>{{ $menu->Title }}</a>
    </li>
    <li class="breadcrumb-item active">
        Menu Items Manager
    </li>
</ol>
