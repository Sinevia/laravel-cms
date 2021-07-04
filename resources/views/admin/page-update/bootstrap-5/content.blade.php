<div class="box box-info">
    <div class="box-header">
        <div>
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>" class="btn btn-info">
                @include("cms::shared/icons/bootstrap/bi-chevron-left")
                Cancel
            </a>

            <button type="button" class="btn btn-success float-end" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                    FORM_PAGE_EDIT.submit();">
                @include("cms::shared/icons/bootstrap/bi-check-all")
                Save
            </button>

            <button type="button" class="btn btn-success float-end" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                    FORM_PAGE_EDIT.submit();">
                @include("cms::shared/icons/bootstrap/bi-check")
                Apply
            </button>

            <a href="<?php echo $page->url(); ?>" class="btn btn-success float-end" target="_blank">
                @include("cms::shared/icons/bootstrap/bi-eye")
                View
            </a>
        </div>
    </div>

    <div class="box-body">

        <form name="FORM_PAGE_EDIT" action="" method="post">
            <!-- START: Tab Navigation -->    
            <ul class="nav nav-tabs" id="PageTab" style="margin-top:20px; margin-bottom: 3px;">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab_content" data-toggle="tab"
                       data-bs-toggle="tab"
                       data-bs-target="#tab_content"
                       type="button"
                       role="tab"
                       aria-controls="tab_content"
                       aria-selected="true"
                       >
                        @include("cms::shared/icons/bootstrap/bi-pencil-square")
                        Content
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab_seo" data-toggle="tab"
                       data-bs-toggle="tab"
                       data-bs-target="#tab_seo"
                       type="button"
                       role="tab"
                       aria-controls="tab_seo"
                       aria-selected="true"
                       >
                        @include("cms::shared/icons/bootstrap/bi-pencil-square")
                        SEO
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tab_settings" data-toggle="tab"
                       data-bs-toggle="tab"
                       data-bs-target="#tab_settings"
                       type="button"
                       role="tab"
                       aria-controls="tab_settings"
                       aria-selected="true"
                       >
                        @include("cms::shared/icons/bootstrap/bi-gear")
                        Settings
                    </a>
                </li>
            </ul>
            <!-- END: Tab Navigation -->

            <!-- START: Tab Panes -->
            <div class="tab-content" id="PageTabContent">

                <!-- START: Content -->
                <div class="tab-pane active" id="tab_content">
                    <div class="card" style="display:table;width:100%;margin-top:10px;margin-bottom: 10px;padding:5px 10px;">
                        <div class="card-body">
                            Page address: <a href="<?php echo $page->url(); ?>" target="_blank"><?php echo $page->url(); ?></a> &nbsp;&nbsp;&nbsp; (to change click on Settings tab)
                        </div>
                    </div>
                    <!-- START: Title -->
                    <div class="form-group mt-3">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Title</a>
                            </li>
                            <li class="nav-item dropdown">
                                <select class="form-control" onchange="showTranslationTitle(this.value);" style="float:left;display: inline;float: left;width: 115px;">
                                    <?php foreach ($page_translations as $tr) { ?>
                                        <?php $language = $tr['Language']; ?>
                                        <?php $selected = ($language == 'en') ? 'selected="selected"' : ''; ?>
                                        <option value="<?php echo $language; ?>" <?php echo $selected; ?>>
                                            <?php echo \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <span style="display: inline-block;margin: 10px;cursor:pointer;">
                                    @include("cms::shared/icons/bootstrap/bi-plus-circle",['onclick'=>'modal_language_add_show();', 'fill'=>'green'])
                                </span>
                                <span style="display: inline-block;margin: 10px;cursor:pointer;">
                                    @include("cms::shared/icons/bootstrap/bi-dash-circle",['onclick'=>"modal_language_delete_show($(this).parent().find('select').val(), $(this).parent().find('select option:selected').text());", 'fill'=>'red'])
                                </span>
                            </li>
                        </ul>

                        <?php foreach ($page_translations as $tr) { ?>
                            <?php $language = $tr['Language']; ?>
                            <?php $display = ($language == 'en') ? '' : 'display:none;'; ?>
                            <div class="page_title_translation" id="page_title_translation_<?php echo $language; ?>" style="<?php echo $display; ?>">
                                <input class="form-control" name="Title[<?php echo $language; ?>]" type="text" value="<?php echo htmlentities($tr['Title']); ?>" />
                            </div>
                        <?php } ?>                                        
                    </div>

                    <script>
                        function showTranslationTitle(language) {
                            $('.page_title_translation').hide();
                            $('#page_title_translation_' + language).show();
                        }
                    </script>
                    <!-- END: Title -->

                    <!-- START: Page Content -->
                    <?php if ($wysiwyg == 'HtmlArea') { ?>
                        <script>
                            setTimeout(function () {
                                $(function () {
                                    var html_area = new HtmlArea('page_content');
                                });
                            }, 2000);
                        </script>
                    <?php } ?>
                    <?php if ($wysiwyg == 'Summernote') { ?>
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet" />
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
                        <script>
                            $(document).ready(function () {
                                $('.page_content').summernote();
                            });
                        </script>
                    <?php } ?>
                    <?php if ($wysiwyg == 'CKEditor') { ?>
                        CKEditorCKEditorCKEditorCKEditorCKEditorCKEditor
                        <script src="https://cdn.ckeditor.com/ckeditor5/10.1.0/classic/ckeditor.js"></script>
                        <script>
                            ClassicEditor
                                    .create(document.querySelectorAll('.page_content'))
                                    .catch(error => {
                                        console.error(error);
                                    });
                        </script>
                    <?php } ?>
                    <?php if ($wysiwyg == 'TinyMCE') { ?>
                        <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
                        <script>
                            tinymce.init({
                                selector: '.page_content',
                                plugins: [
                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                    "insertdatetime media table nonbreaking save contextmenu directionality paste"
                                ],
                                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                                relative_urls: false,
                                remove_script_host: false,
                                convert_urls: true,
                                force_br_newlines: true,
                                force_p_newlines: false,
                                forced_root_block: '' // Needed for 3.x
                            });</script>
                    <?php } ?>
                    <?php if ($wysiwyg == 'CodeMirror') { ?>
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
                                    $('.page_content').each(function () {
                                        var editor = CodeMirror.fromTextArea(this, {
                                            lineNumbers: true,
                                            matchBrackets: true,
                                            mode: "application/x-httpd-php",
                                            indentUnit: 4,
                                            indentWithTabs: true,
                                            enterMode: "keep", tabMode: "shift"});
                                    });
                                    //                            var editor = CodeMirror.fromTextArea(document.getElementById("page_content"), {
                                    //                                lineNumbers: true,
                                    //                                matchBrackets: true,
                                    //                                mode: "application/x-httpd-php",
                                    //                                indentUnit: 4,
                                    //                                indentWithTabs: true,
                                    //                                enterMode: "keep", tabMode: "shift"});
                                });
                            }, 2000);
                        </script>
                    <?php } ?>
                    <?php if ($wysiwyg == 'BlockEditor') { ?>
                        <script src="https://code.jquery.com/ui/1.12.0-beta.1/jquery-ui.min.js"></script>
                        <script src="https://openwhisk.eu-gb.bluemix.net/api/v1/web/sinevia_live/default/blockarea/blockarea/"></script>
                        <script>
                            setTimeout(function () {
                                $(function () {
                                    $('.page_content_translation').each(function () {
                                        var randomId = 'random_' + Math.random().toString(36).replace(/[^a-z]+/g, '').substr(2, 10);
                                        var textArea = $(this).find('textarea');
                                        $(textArea).attr('id', randomId)

                                        var blocksString = $(textArea).val();
                                        var editorId = $(textArea).attr('id');
                                        //var parentId = $('#blockarea').attr('ParentId');
                                        var blockArea = new BlockArea(editorId);
                                        if (blocksString != "") {
                                            blockArea.setBlocks(JSON.parse(blocksString));
                                        } else {
                                            blockArea.setBlocks([]);
                                        }
                                        blockArea.setParentId('<?php echo $page->Id; ?>');
                                        blockArea.init();
                                    });
                                });
                            }, 2000);
                        </script>
                    <?php } ?>
                    <div class="form-group mt-3" style="width:100%;">
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMediaManager() ?>" target="_blank" class="btn btn-primary pull-right">
                            Media
                        </a>
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Content</a>
                            </li>
                            <li class="nav-item dropdown">
                                <select class="form-control" onchange="showTranslationContent(this.value);" style="float:left;display: inline;float: left;width: 115px;">
                                    <?php foreach ($page_translations as $tr) { ?>
                                        <?php $language = $tr['Language']; ?>
                                        <?php $selected = ($language == 'en') ? 'selected="selected"' : ''; ?>
                                        <option value="<?php echo $language; ?>" <?php echo $selected; ?>>
                                            <?php echo \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language); ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <span style="display: inline-block;margin: 10px;cursor:pointer;">
                                    @include("cms::shared/icons/bootstrap/bi-plus-circle",['onclick'=>'modal_language_add_show();', 'fill'=>'green'])
                                </span>
                                <span style="display: inline-block;margin: 10px;cursor:pointer;">
                                    @include("cms::shared/icons/bootstrap/bi-dash-circle",['onclick'=>"modal_language_delete_show($(this).parent().find('select').val(), $(this).parent().find('select option:selected').text());", 'fill'=>'red'])
                                </span>
                            </li>
                        </ul>
                        <?php foreach ($page_translations as $tr) { ?>
                            <?php $language = $tr['Language']; ?>
                            <?php $display = ($language == 'en') ? '' : 'display:none;'; ?>
                            <div class="page_content_translation" id="page_content_translation_<?php echo $language; ?>" style="min-height:50px;<?php echo $display; ?>">
                                <textarea class="form-control page_content" name="Content[<?php echo $language; ?>]" style="height:300px;width:100%;"><?php echo htmlentities($tr['Content']); ?></textarea>
                            </div>
                        <?php } ?>
                    </div>
                    <script>
                        function showTranslationContent(language) {
                            $('.page_content_translation').hide();
                            $('#page_content_translation_' + language).show();
                        }
                    </script>
                    <!-- END: Page Content -->

                </div>
                <!-- END: Content -->

                <!-- START: SEO -->
                <div class="tab-pane" id="tab_seo">
                    <!-- START: Alias -->
                    <div class="form-group mt-3">                     
                        <label for="page_alias">
                            Alias / Path
                        </label>
                        <input class="form-control" name="Alias" type="text" value="<?php echo $alias; ?>" />
                    </div>
                    <!-- END: Alias -->                

                    <!-- START: Meta Keywords -->
                    <div class="form-group mt-3">               
                        <label for="page_meta_keywords">
                            Meta Keywords
                        </label>
                        <input class="form-control" name="MetaKeywords" type="text" value="<?php echo $metaKeywords; ?>" />
                    </div>
                    <!-- END: Meta Keywords -->

                    <!-- START: Meta Description -->
                    <div class="form-group mt-3">                   
                        <label for="page_meta_description">
                            Meta Description
                        </label>
                        <input class="form-control" name="MetaDescription" type="text" value="<?php echo $metaDescription; ?>" />
                    </div>
                    <!-- END: Meta Description -->

                    <!-- START: Meta Robots -->
                    <div class="form-group mt-3">               
                        <label>
                            Meta Robots Follow
                        </label>
                        <select class="form-control" name="MetaRobots">
                            <option value=""></option>
                            <?php $selected = ($metaRobots == 'INDEX, FOLLOW') ? 'selected="selected"' : ''; ?>
                            <option value="INDEX, FOLLOW" <?php echo $selected ?> >INDEX, FOLLOW</option>
                            <?php $selected = ($metaRobots == 'NOINDEX, FOLLOW') ? 'selected="selected"' : ''; ?>
                            <option value="NOINDEX, FOLLOW" <?php echo $selected ?> >NOINDEX, FOLLOW</option>
                            <?php $selected = ($metaRobots == 'INDEX, NOFOLLOW') ? 'selected="selected"' : ''; ?>
                            <option value="INDEX, NOFOLLOW" <?php echo $selected ?> >INDEX, NOFOLLOW</option>
                            <?php $selected = ($metaRobots == 'NOINDEX, NOFOLLOW') ? 'selected="selected"' : ''; ?>
                            <option value="NOINDEX, NOFOLLOW" <?php echo $selected ?> >NOINDEX, NOFOLLOW</option>
                        </select>
                    </div>
                    <!-- END: Meta Robots -->

                    <!-- START: Canonical Url -->
                    <div class="form-group mt-3">                   
                        <label>
                            Canonical URL
                        </label>
                        <input class="form-control" name="CanonicalUrl" type="text" value="<?php echo $canonicalUrl; ?>" />
                        <div class="text-info">
                            The canonical URL that this page should point to.
                            Leave empty to default to default page URL.
                        </div>
                    </div>
                    <!-- END: Canonical Url -->
                </div>
                <!-- END: SEO -->

                <!-- START: Settings -->
                <div class="tab-pane" id="tab_settings">
                    <!-- START: Access -->
                    <div class="form-group mt-3">
                        <label>
                            Access
                        </label>
                        <select class="form-control" name="Access">
                            <?php $selected = ($access == 'Public') ? 'selected="selected"' : ''; ?>
                            <option value="Public" <?php echo $selected ?> >Public - Everyone can see</option>
                            <?php $selected = ($access == 'Members') ? 'selected="selected"' : ''; ?>
                            <option value="Members" <?php echo $selected ?> >Members Only</option>
                        </select>
                    </div>
                    <!-- END: Access -->

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

                    <!-- START: Template -->
                    <div class="form-group mt-3">
                        <label for="page_template">
                            Template
                        </label>
                        <select class="form-control" name="TemplateId">
                            <option value="">None</option>
                            <?php foreach ($templateList as $t) { ?>
                                <?php $selected = ($templateId == $t->Id) ? 'selected="selected"' : ''; ?>
                                <option value="<?php echo $t->Id; ?>" <?php echo $selected ?>>
                                    <?php echo $t->Title; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- END: Template -->

                    <!-- START: Summary -->
                    <div class="form-group mt-3">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Summary</a>
                            </li>
                            <li class="nav-item dropdown">
                                <select class="form-control" onchange="showTranslationSummary(this.value);" style="float:left;display: inline;float: left;width: 115px;">
                                    <?php foreach ($page_translations as $tr) { ?>
                                        <?php $language = $tr['Language']; ?>
                                        <?php $selected = ($language == 'en') ? 'selected="selected"' : ''; ?>
                                        <option value="<?php echo $language; ?>" <?php echo $selected; ?>>
                                            <?php echo \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                
                                <span style="display: inline-block;margin: 10px;cursor:pointer;">
                                    @include("cms::shared/icons/bootstrap/bi-plus-circle",['onclick'=>'modal_language_add_show();', 'fill'=>'green'])
                                </span>
                                <span style="display: inline-block;margin: 10px;cursor:pointer;">
                                    @include("cms::shared/icons/bootstrap/bi-dash-circle",['onclick'=>"modal_language_delete_show($(this).parent().find('select').val(), $(this).parent().find('select option:selected').text());", 'fill'=>'red'])
                                </span>
                            </li>
                        </ul>

                        <?php foreach ($page_translations as $tr) { ?>
                            <?php $language = $tr['Language']; ?>
                            <?php $display = ($language == 'en') ? '' : 'display:none;'; ?>
                            <div class="page_summary_translation" id="page_summary_translation_<?php echo $language; ?>" style="<?php echo $display; ?>">
                                <textarea class="form-control page_summary" name="Summary[<?php echo $language; ?>]" style="height:100px;width:100%;"><?php echo htmlentities($tr['Summary']); ?></textarea>
                            </div>
                        <?php } ?>
                    </div>

                    <script>
                        function showTranslationSummary(language) {
                            $('.page_summary_translation').hide();
                            $('#page_summary_translation_' + language).show();
                        }
                    </script>
                    <!-- END: Summary -->

                    <!-- START: Wysiwyg Editor -->
                    <div class="form-group mt-3">
                        <label for="page_wysiwyg">
                            Content Editors
                        </label>
                        <select class="form-control" name="Wysiwyg" id="page_wysiwyg">
                            <?php $selected = ($wysiwyg == 'None') ? 'selected="selected"' : ''; ?>
                            <option value="None" <?php echo $selected ?> >None</option>                            
                            <?php $selected = ($wysiwyg == 'CodeMirror') ? 'selected="selected"' : ''; ?>
                            <option value="CodeMirror" <?php echo $selected ?> >CodeMirror - Syntax Highlihter (recommended)</option>
                            <?php $selected = ($wysiwyg == 'Summernote') ? 'selected="selected"' : ''; ?>
                            <option value="Summernote" <?php echo $selected ?> >Summernote - Wysiwyg (not recommended)</option>
                            <?php $selected = ($wysiwyg == 'CKEditor') ? 'selected="selected"' : ''; ?>
                            <option value="CKEditor" <?php echo $selected ?> >CKEditor - Wysiwyg (not recommended)</option>                            
                            <?php $selected = ($wysiwyg == 'TinyMCE') ? 'selected="selected"' : ''; ?>
                            <option value="TinyMCE" <?php echo $selected ?> >TinyMCE - Wysiwyg (not recommended)</option>
                            <?php $selected = ($wysiwyg == 'BlockEditor') ? 'selected="selected"' : ''; ?>
                            <option value="BlockEditor" <?php echo $selected ?> >BlockEditor - Experimental</option>
                            <!--
                            <?php $selected = ($wysiwyg == 'HtmlArea') ? 'selected="selected"' : ''; ?>
                            <option value="HtmlArea" <?php echo $selected ?> >HtmlArea - Wysiwyg (not recommended)</option>
                            -->
                        </select>
                        <p class="text-warning">
                            <i class="fa fa-warning"></i>
                            Beware when changing to wysiwyg as it may destroy content.
                            Use wysiwyg only if the page will be managed by non-technical users.
                        </p>
                    </div>
                    <!-- END: Wysiwyg Editor -->
                </div>
                <!-- END: Settings -->

            </div>
            <!-- END: Tab Panes -->

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="action" id="form_action" value="save-and-exit">
        </form>
    </div>

    <div class="box box-footer" style="margin-top:20px;">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>" class="btn btn-info">
            @include("cms::shared/icons/bootstrap/bi-chevron-left")
            Cancel
        </a>

        <button type="button" class="btn btn-success float-end" style="margin:0px 10px;"  onclick="$('#form_action').val('save-and-exit');
                FORM_PAGE_EDIT.submit();">
            @include("cms::shared/icons/bootstrap/bi-check-all")
            Save
        </button>

        <button id="ButtonApply" type="button" class="btn btn-success float-end" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                FORM_PAGE_EDIT.submit();">
            @include("cms::shared/icons/bootstrap/bi-check")
            Apply
        </button>

        <a href="<?php echo $page->url(); ?>" class="btn btn-success float-end" target="_blank">
            @include("cms::shared/icons/bootstrap/bi-eye")
            View
        </a>
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
            return false;
        });
    }, 500);
</script>

<!-- START: File Upload Modal Dialog -->
<div class="modal fade" id="modal_file_upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Choose Image to Upload
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form_upload_file" method="post" target="iframe_file_upload" action="?cmd=page-file-upload" enctype="multipart/form-data" style="margin:0px;padding:0px;">
                    <div class="form-group">
                        <label for="file_upload_file">
                            File
                        </label>
                        <input class="input-file" name="file_upload" type="file" id="file_upload_file">
                    </div>
                    <div style="padding:10px;margin-top:15px;">
                        Please note! Only image files (.png, .jpg, .gif) are allowed.
                    </div>
                    <input type="hidden" name="sid" value="<?php echo session_id(); ?>">
                    <input type="hidden" name="id" value="<?php echo $page->Id; ?>">
                </form>
                <iframe name="iframe_file_upload" style="display:none;"></iframe>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button class="btn btn-success" data-dismiss="modal" onclick="$('#loading').show();
                        form_upload_file.submit();">
                    <span class="glyphicon glyphicon-upload"></span>
                    Upload
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function modal_file_upload_show() {
        $('#modal_file_upload').modal('show');
    }
</script>
<!-- END: File Upload Modal Dialog -->



<!-- START: Add Translation -->
<div class="modal fade" id="modal_language_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Add Translation Language
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form_language_add" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminPageTranslationCreate(); ?>" style="margin:0px;padding:0px;">
                    <div class="form-group">
                        <label for="file_upload_file">
                            Language
                        </label>
                        <select name="Language" class="form-control">
                            <?php foreach (\Sinevia\Cms\Helpers\Languages::getLanguagesAsIso1() as $iso1) { ?>
                                <option value="<?php echo $iso1; ?>">
                                    <?php echo \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($iso1); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style="padding:10px;margin-top:15px;color:red;">
                        Please save all unsaved changes you have made first!.
                    </div>
                    <input type="hidden" name="sid" value="<?php echo session_id(); ?>">
                    <input type="hidden" name="PageId" value="<?php echo $page->Id; ?>">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Cancel
                </button>
                <button class="btn btn-success" data-dismiss="modal" onclick="$('#loading').show();
                        form_language_add.submit();">
                    @include("cms::shared/icons/bootstrap/bi-plus-circle")
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
                <h5 class="modal-title">
                    Delete <span class="modal_language_delete_language_name"></span> Translation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="form_language_delete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminPageTranslationDelete(); ?>" style="margin:0px;padding:0px;">
                    <div style="padding:10px;margin-top:15px;color:red;font-weight:bold;font-size:16px;">
                        Are you sure you want to delete <span class="modal_language_delete_language_name"></span> translation.
                        Beware! This action cannot be reversed.
                    </div>
                    <input type="hidden" id="form_language_delete_language_code" name="Language" value="">
                    <input type="hidden" name="sid" value="<?php echo session_id(); ?>">
                    <input type="hidden" name="PageId" value="<?php echo $page->Id; ?>">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Cancel
                </button>
                <button class="btn btn-warning" data-dismiss="modal" onclick="$('#loading').show();
                        form_language_delete.submit();">
                    @include("cms::shared/icons/bootstrap/bi-dash-circle")
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
