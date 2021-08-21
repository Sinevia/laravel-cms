<div class="box box-info">
    <div class="box-header">
        <div>
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetManager(); ?>" class="btn btn-info">
                @include("cms::shared/icons/bootstrap/bi-chevron-left")
                Cancel
            </a>

            <button type="button" class="btn btn-success float-end" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                    FORM_WIDGET_EDIT.submit();">
                @include("cms::shared/icons/bootstrap/bi-check-all")
                Save
            </button>

            <button type="button" class="btn btn-success float-end" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                    FORM_WIDGET_EDIT.submit();">
                @include("cms::shared/icons/bootstrap/bi-check")
                Apply
            </button>
        </div>
    </div>

    <div class="box-body">

        <form name="FORM_WIDGET_EDIT" action="" method="post">

            <!-- START: Status -->
            <div class="form-group mt-3">
                <label>
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
            <div class="form-group mt-3">
                <label>
                    Title
                </label>
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
                setTimeout(function () {
                    $(function () {
                        var editor = CodeMirror.fromTextArea(document.getElementById("WidgetContent"), {
                            lineNumbers: true,
                            matchBrackets: true,
                            mode: "application/x-httpd-php",
                            indentUnit: 4,
                            indentWithTabs: true,
                            enterMode: "keep", tabMode: "shift"});
                    });
                }, 2000);
            </script>
            <!-- END: Code Mirror -->

            <!-- START: Content -->
            <div class="form-group mt-3">
                <label>
                    Content
                </label>
                <textarea class="form-control" id="WidgetContent" name="Content" style="height:100px;width:100%;"><?php echo htmlentities($content); ?></textarea>
            </div>
            <!-- END: Content -->

            <div class="form-group mt-3">
                <label>
                    Cache
                </label>
                <select class="form-control" name="Cache">
                    <option value="-1">No Cache</option>
                    <?php for ($i = 30; $i < 601; $i += 30) { ?>
                        <?php $selected = ($cache == $i) ? 'selected="selected"' : ''; ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected ?> >
                            <?php echo ($i / 60); ?> min
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group mt-3">
                <label>
                    Type
                </label>
                <select class="form-control" name="Type" id="Type" onchange="type_selected();">
                    <option value="">None</option>
                    <?php asort($types); ?>
                    <?php foreach ($types as $t) { ?>
                        <?php $selected = ($type == basename($t)) ? 'selected="selected"' : ''; ?>
                        <option value="<?php echo basename($t); ?>" <?php echo $selected ?>>
                            <?php echo basename($t); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div id="widget_parameters"></div>

            <script>
                setTimeout(function () {
                    $(function () {
                        type_selected();
                    });
                }, 2000);

                function type_selected() {
                    var parameters = <?php echo json_encode($parameters); ?>;
                    var type = $('#Type').val();
                    if (type === "") {
                        $('#widget_parameters').html('Please, select a type');
                    }
                    var url = '<?php echo $parametersFormUrl; ?>' + '?Type=' + type;
                    $('#widget_parameters').load(url, function () {
                        form_populate($('#widget_parameters'), parameters);
                    });

                }
                function form_populate(form, data) {
                    // DEBUG: console.log(data);

                    $.each(data, function (key, value) {
                        key = 'Parameters[' + key + ']';
                        var name_key = key.split('[').join('\\[').split(']').join('\\]');
                        var $ctrl = $('[name=' + name_key + ']', form);
                        var type = $ctrl.attr("type");
                        var tag = $ctrl.prop("tagName").toLowerCase();
                        console.log(name_key + ":" + value);
                        console.log(tag);
                        if (tag === 'input') {
                            var type = $ctrl.attr("type");
                            if (type === "radio" || type === "checkbox") {
                                $ctrl.each(function () {
                                    if ($(this).attr('value') === value) {
                                        $(this).attr("checked", value);
                                    }
                                });
                            } else {
                                $ctrl.val(value);
                            }
                        }
                        if (tag === "select") {
                            $ctrl.val(value);
                        }
                        if (tag === "textarea") {
                            $ctrl.val(value);
                        }
                    });
                }
            </script>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="action" id="form_action" value="save-and-exit">
        </form>
    </div>

    <div class="box box-footer mt-3">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetManager(); ?>" class="btn btn-info">
            @include("cms::shared/icons/bootstrap/bi-chevron-left")
            Cancel
        </a>

        <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                FORM_WIDGET_EDIT.submit();">
            @include("cms::shared/icons/bootstrap/bi-check-all")
            Save
        </button>

        <button type="button" id="ButtonApply" class="btn btn-success pull-right" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                FORM_WIDGET_EDIT.submit();">
            @include("cms::shared/icons/bootstrap/bi-check")
            Apply
        </button>
    </div>


</div>

<br />
<br />
<br />

<script type="text/javascript">
    setTimeout(function () {
        $(window).bind('keydown', function (event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        $('#ButtonApply').trigger('click');
                        break;
                }
            }
        });
    }, 500);
</script>

<p class="text-info">
    <i class="glyphicon glyphicon-info-sign"></i>
    To use this widget in your website use the following shortcode:
    <code>
        <pre>
    &lt;!-- START: Widget: <?php echo $widget->Title; ?> -->
    [[WIDGET_<?php echo $widget->Id ?>]]
    &lt;!-- END: Widget: <?php echo $widget->Title; ?> -->
        </pre>
    </code>
</p>

<br />
<br />
<br />
