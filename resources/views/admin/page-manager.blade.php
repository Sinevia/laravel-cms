<?php
$masterTemplate = trim(config('cms.layout-master'));
$hasMasterTemplate = ($masterTemplate != "");
if ($hasMasterTemplate) {
    $hasMasterTemplate = View::exists($masterTemplate);
}
?>
<?php if ($hasMasterTemplate == true) { ?>
    @extends($masterTemplate)
<?php } ?>

@section('webpage_title', 'Page Manager')

@section('webpage_header')
<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::admin/page-manager/bootstrap-5/header')
<?php } else { ?>
    @include('cms::admin/page-manager/bootstrap-4/header')
<?php } ?>
@stop

@section('webpage_content')

<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::shared/bootstrap-5/css')
<?php } ?>
    
@include('cms::shared.navigation')

<?php if (config("cms.bootstrap-version") == 5) { ?>
    @include('cms::admin/page-manager/bootstrap-5/content')
<?php } else { ?>
    @include('cms::admin/page-manager/bootstrap-4/content')
<?php } ?>

@stop
