<?php if (View::exists(config('cms.layout-master'))) { ?>
    @extends(config('cms.layout-master'))
<?php } ?>

@section('webpage_title', 'Edit Block')

@section('webpage_header')
<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::admin/block-update/bootstrap-5/header')
<?php } else { ?>
    @include('cms::admin/block-update/bootstrap-4/header')
<?php } ?>
@stop

@section('webpage_content')

<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::shared/bootstrap-5/css')
<?php } ?>

@include('cms::shared.navigation')

<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::admin/block-update/bootstrap-5/content')
<?php } else { ?>
    @include('cms::admin/block-update/bootstrap-4/content')
<?php } ?>

@stop
