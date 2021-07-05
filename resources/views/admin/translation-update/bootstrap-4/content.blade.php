<div class="box box-info">
    <div class="box-header">
        <div>
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationManager(); ?>" class="btn btn-info">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Cancel
            </a>

            <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                    FORM_TRANSLATION_EDIT.submit();">
                <span class="glyphicon glyphicon-floppy-saved"></span>
                Save
            </button>

            <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                    FORM_TRANSLATION_EDIT.submit();">
                <span class="glyphicon glyphicon-floppy-save"></span>
                Apply
            </button>
        </div>
    </div>

    <div class="box-body">

        <form name="FORM_TRANSLATION_EDIT" action="" method="post">

            <!-- START: Key -->
            <div class="form-group">
                <label>Key</label>
                <input class="form-control" name="Key" type="text" value="<?php echo htmlentities($key); ?>" />
            </div>
            <!-- END: Key -->


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
                    $('.translation_content').each(function () {
                        var editor = CodeMirror.fromTextArea(this, {
                            lineNumbers: true,
                            matchBrackets: true,
                            mode: "application/x-httpd-php",
                            indentUnit: 4,
                            indentWithTabs: true,
                            enterMode: "keep", tabMode: "shift"
                        });
                    });
                });
            </script>
            <!-- END: Code Mirror -->

            <!-- START: Content -->
            <div class="form-group">
                <label for="translationKey_content">
                    Content
                </label>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Content</a></li>
                    <li class="dropdown">
                        <select class="form-control" onchange="showTranslationContent(this.value);" style="float:left;display: inline;float: left;width: 115px;">
                            <?php foreach ($translationValues as $tr) { ?>
                                <?php $language = $tr['Language']; ?>
                                <?php $selected = ($language == 'en') ? 'selected="selected"' : ''; ?>
                                <option value="<?php echo $language; ?>" <?php echo $selected; ?>>
                                    <?php echo \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="glyphicon glyphicon-plus-sign" onclick="modal_language_add_show();" style="color:green;margin: 10px;cursor:pointer;"></span>
                        <span class="glyphicon glyphicon-minus-sign" onclick="modal_language_delete_show($(this).parent().find('select').val(), $(this).parent().find('select option:selected').text());" style="color:red;margin: 10px 5px;cursor:pointer;"></span>
                    </li>
                </ul>
                <?php foreach ($translationValues as $tr) { ?>
                    <?php $language = $tr['Language']; ?>
                    <?php $display = ($language == 'en') ? '' : 'display:none;'; ?>
                    <div class="translation_content_translation" id="translation_content_translation_<?php echo $language; ?>" style="min-height:50px;<?php echo $display; ?>">
                        <textarea class="form-control translation_content" name="Content[<?php echo $language; ?>]" style="height:300px;width:100%;"><?php echo htmlentities($tr['Value']); ?></textarea>
                    </div>
                <?php } ?>
                <script>
                    function showTranslationContent(language) {
                        $('.translation_content_translation').hide();
                        $('#translation_content_translation_' + language).show();
                    }
                </script>

            </div>
            <!-- END: Content -->

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="action" id="form_action" value="save-and-exit">
        </form>

    </div>

    <div class="box box-footer">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationManager(); ?>" class="btn btn-info">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Cancel
        </a>

        <button type="button" class="btn btn-success pull-right" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                FORM_TRANSLATION_EDIT.submit();">
            <span class="glyphicon glyphicon-floppy-saved"></span>
            Save
        </button>

        <button type="button" id="ButtonApply" class="btn btn-success pull-right" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                FORM_TRANSLATION_EDIT.submit();">
            <span class="glyphicon glyphicon-floppy-save"></span>
            Apply
        </button>
    </div>


</div>

<br />
<br />
<br />

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

<!-- START: Add Translation -->
<div class="modal fade" id="modal_language_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Translation Language</h4>
            </div>
            <div class="modal-body">
                <form name="form_language_add" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationValueCreate(); ?>" style="margin:0px;padding:0px;">
                    <div class="form-group">
                        <label for="file_upload_file">
                            Language
                        </label>
                        <select name="Language" class="form-control">
                            <?php foreach (\Sinevia\Cms\Helpers\Languages::getLanguagesAsIso1() as $iso1) { ?>
                                <option value="<?php echo $iso1; ?>"><?php echo \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($iso1); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style="padding:10px;margin-top:15px;color:red;">
                        Please save all unsaved changes you have made first!.
                    </div>
                    <input type="hidden" name="KeyId" value="<?php echo $translationKey->Id; ?>" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </button>
                <button class="btn btn-success" data-dismiss="modal" onclick="$('#loading').show();
                        form_language_add.submit();">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    Add Translation
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function modal_language_add_show() {
        $('#modal_language_add').modal('show');
    }
</script>
<!-- START: Add Translation -->

<!-- START: Delete Translation -->
<div class="modal fade" id="modal_language_delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete <span class="modal_language_delete_language_name"></span> Translation</h4>
            </div>
            <div class="modal-body">
                <form name="form_language_delete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationValueDelete(); ?>" style="margin:0px;padding:0px;">
                    <div style="padding:10px;margin-top:15px;color:red;font-weight:bold;font-size:16px;">
                        Are you sure you want to delete <span class="modal_language_delete_language_name"></span> translation.
                        Beware! This action cannot be reversed.
                    </div>
                    <input type="hidden" id="form_language_delete_language_code" name="Language" value="" />
                    <input type="hidden" name="KeyId" value="<?php echo $translationKey->Id; ?>" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </button>
                <button class="btn btn-warning" data-dismiss="modal" onclick="$('#loading').show();
                        form_language_delete.submit();">
                    <span class="glyphicon glyphicon-remove-sign"></span>
                    Delete Translation
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function modal_language_delete_show(language_code, language_name) {
        $('.modal_language_delete_language_name').html(language_name);
        $('#form_language_delete_language_code').val(language_code);
        $('#modal_language_delete').modal('show');
    }
</script>
<!-- START: Delete Translation -->
