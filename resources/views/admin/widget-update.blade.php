@extends('admin.layout')

@section('webpage_title', 'Edit Widget')

@section('webpage_header')
<h1>
    Edit Widget: <?php echo $widget->Title; ?>
    <small>(#<?php echo $widget->Id; ?>)</small>
</h1>
<ol class="breadcrumb">
    <li><a href="<?php echo action('Admin\HomeController@anyIndex'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo action('Admin\CmsController@getWidgetManager'); ?>">CMS</a></li>
    <li><a href="<?php echo action('Admin\CmsController@getWidgetManager'); ?>">Widgets</a></li>
    <li class="active">Edit Widget</li>
</ol>
@stop

@section('webpage_content')

@include('cms::shared.navigation')

<div class="box box-info">
    <div class="box-header">
        <div>
            <a href="<?php echo action('Admin\CmsController@getWidgetManager'); ?>" class="btn btn-info">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Cancel
            </a>

            <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                    FORM_WIDGET_EDIT.submit();">
                <span class="glyphicon glyphicon-floppy-saved"></span>
                Save
            </button>

            <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                    FORM_WIDGET_EDIT.submit();">
                <span class="glyphicon glyphicon-floppy-save"></span>
                Apply
            </button>
        </div>
    </div>

    <div class="box-body">

        <form name="FORM_WIDGET_EDIT" action="" method="post">

            <!-- START: Status -->
            <div class="form-group">
                <label for="page_status">
                    Status
                </label>
                <select class="form-control" name="Status">
                    <option value=""></option>
                    <?php $selected = ($status == 'Deleted') ? 'selected="selected"' : ''; ?>
                    <option value="Deleted" <?php echo $selected ?> >Deleted</option>
                    <?php $selected = ($status == 'Draft') ? 'selected="selected"' : ''; ?>
                    <option value="Draft" <?php echo $selected ?> >Draft</option>
                    <?php $selected = ($status == 'Published') ? 'selected="selected"' : ''; ?>
                    <option value="Published" <?php echo $selected ?> >Published</option>
                    <?php $selected = ($status == 'Unpublished') ? 'selected="selected"' : ''; ?>
                    <option value="Unpublished" <?php echo $selected ?> >Unpublished</option>
                </select>
            </div>
            <!-- END: Status -->


            <!-- START: Title -->
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" name="Title" type="text" value="<?php echo htmlentities($title); ?>" />
            </div>
            <!-- END: Title -->


            <!-- START: Code Mirror -->
            <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.css" />
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.js"></script>
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/htmlmixed/htmlmixed.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/javascript/javascript.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/css/css.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/clike/clike.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/php/php.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.22.0/addon/edit/matchbrackets.min.js"></script>

            <style>
                .CodeMirror {
                    border: 1px solid #eee;
                    height: auto;
                }
            </style>
            <script>
                $(function () {
                    var editor = CodeMirror.fromTextArea(document.getElementById("WidgetContent"), {
                        lineNumbers: true,
                        matchBrackets: true,
                        mode: "application/x-httpd-php",
                        indentUnit: 4,
                        indentWithTabs: true,
                        enterMode: "keep", tabMode: "shift"});
                });
            </script>
            <!-- END: Code Mirror -->

            <!-- START: Content -->
            <div class="form-group">
                <label>
                    Content
                </label>
                <textarea class="form-control" id="WidgetContent" name="Content" style="height:100px;width:100%;"><?php echo htmlentities($content); ?></textarea>
            </div>
            <!-- END: Content -->

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="action" id="form_action" value="save-and-exit">
        </form>
    </div>

    <div class="box box-footer">
        <a href="<?php echo action('Admin\CmsController@getWidgetManager'); ?>" class="btn btn-info">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Cancel
        </a>

        <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                FORM_WIDGET_EDIT.submit();">
            <span class="glyphicon glyphicon-floppy-saved"></span>
            Save
        </button>

        <button type="button" id="ButtonApply" class="btn btn-success pull-right" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                FORM_WIDGET_EDIT.submit();">
            <span class="glyphicon glyphicon-floppy-save"></span>
            Apply
        </button>
    </div>


</div>

<script type="text/javascript">
    $(window).keypress(function (event) {
        if (!(event.which === 115 && event.ctrlKey) && !(event.which === 19)) {
            return true;
        }
        $('#ButtonApply').trigger('click');
        event.preventDefault();
        return false;
    });
</script>

@stop