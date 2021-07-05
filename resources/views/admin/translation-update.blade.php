<?php if (View::exists(config('cms.layout-master'))) { ?>
    @extends(config('cms.layout-master'))
<?php } ?>

@section('webpage_title', 'Edit Translation')

@section('webpage_header')
<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::admin/translation-update/bootstrap-5/header')
<?php } else { ?>
    @include('cms::admin/translation-update/bootstrap-4/header')
<?php } ?>
@stop

@section('webpage_content')
@include('cms::shared.navigation')
<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::admin/translation-update/bootstrap-5/content')
<?php } else { ?>
    @include('cms::admin/translation-update/bootstrap-4/content')
<?php } ?>
@stop
