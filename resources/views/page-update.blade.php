@extends('knowledge::shared.layout-pages-menu-left')

@section('title', 'Edit page')

@section('page-content')

@section('page-content')
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.css" />-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/tokenfield-typeahead.min.css" />-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.css" />

<h1>
    {{ $page->Title }}
    <button class="btn btn-success float-right" onclick="formPageUpdateSubmit(this);">
        Save
        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
    </button>
</h1>

<div class="FormPageUpdate">
    <div class="alert alert-success" style="display:none;"></div>
    <div class="alert alert-danger" style="display:none;"></div>
    <div class="form-group">
        <label style="display:none;">Parent</label>
        <input type="hidden" id="ParentId" name="ParentId" value="<?php echo $page->ParentId; ?>" />
    </div>
    <div class="form-group">
        <label>Title</label>
        <input name="Title" value="{{ $page->Title }}" class="form-control" />
    </div>
    <div class="form-group">
        <label>Text</label>
        <!--<input type="hidden" name="Text" class="form-control" value="{{ $page->Text }}" />-->
        <!--<div id="Text">{!! $page->Text !!}</div>-->
        <textarea id="Text" name="Text" class="form-control">{{ $page->Text }}</textarea>
    </div>
    <input type="hidden" name="PageId" value="<?php echo $page->Id; ?>" />
    <?php echo csrf_field(); ?>
</div>

@include('knowledge::page-create-modal')

@stop

@push('scripts')
<script>
    function formPageUpdateSubmit(button) {
        var pageUpdateUrl = '<?php echo action('\Sinevia\Knowledge\Controllers\KnowledgeController@anyPageUpdateAjax'); ?>';
        var data = $('.FormPageUpdate :input').serialize();
        $(button).find('.fa-spinner').show();

        $('.FormPageUpdate .alert-success').fadeOut().html('');
        $('.FormPageUpdate .alert-danger').fadeOut().html('');

        $.post(pageUpdateUrl, data).then(function (responseString) {
            var response = JSON.parse(responseString);
            console.log(response)

            if (response.status === "success") {
                var pageId = response.data.PageId;
                var messages = response.message;
                $('.FormPageUpdate .alert-success').fadeIn().html(messages);
                return;
            }

            if (response.status === "error") {
                var messages = response.message;
                messages = $.isArray(messages) ? messages.join('<br />') : messages;
                $('.FormPageUpdate .alert-danger').fadeIn().html(messages);
                return;
            }
        }).fail(function (response) {
            $('.FormPageUpdate .alert-danger').fadeIn().html('There was server error. Please try again later');
        }).always(function () {
            $(button).find('.fa-spinner').hide();
        });
    }
</script>
<?php
$items = [];
foreach ($pathArray as $p) {
    $items[] = ['id' => $p->Id, 'value' => $p->Title];
}
?>
<!-- include summernote css/js-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.js"></script>
<script>
    /**
     * Summernote Fixed Toolbar
     *
     * This is a plugin for Summernote (www.summernote.org) WYSIWYG editor.
     * It will keep the toolbar fixed to the top of the screen as you scroll.
     *
     * @author Byrne, FloSports <jason.byrne@flosports.tv>
     *
     */
    (function (factory) {
        /* global define */
        if (typeof define === 'function' && define.amd) {
            // AMD. Register as an anonymous module.
            define(['jquery'], factory);
        } else if (typeof module === 'object' && module.exports) {
            // Node/CommonJS
            module.exports = factory(require('jquery'));
        } else {
            // Browser globals
            factory(window.jQuery);
        }
    }(function ($) {
        // Extends plugins for adding hello.
        //  - plugin is external module for customizing.
        $.extend($.summernote.plugins, {
            /**
             * @param {Object} context - context object has status of editor.
             */
            'fixedToolbar': function (context) {
                var self = this;
                var ui = $.summernote.ui;
                var $editor = context.layoutInfo.editor;
                var $toolbar = $editor.find('.note-toolbar');

                //Scrolling event
                var repositionToolbar = function () {
                    var windowTop = $(window).scrollTop();
                    var editorTop = $editor.offset().top;
                    var editorBottom = editorTop + $editor.height();
                    if (windowTop > editorTop && windowTop < editorBottom) {
                        $toolbar.css('position', 'fixed');
                        $toolbar.css('top', '0px');
                        $toolbar.css('width', $editor.width() + 'px');
                        $toolbar.css('z-index', '99999');
                        $editor.css('padding-top', '42px');
                    } else {
                        $toolbar.css('position', 'static');
                        $editor.css('padding-top', '0px');
                    }
                };
                // Move it
                $(window).scroll(repositionToolbar);


                // This events will be attached when editor is initialized.
                this.events = {
                    // This will be called after modules are initialized.
                    'summernote.init': function (we, e) {
                        console.log('summernote initialized', we, e);
                        repositionToolbar();
                    },
                    // This will be called when user releases a key on editable.
                    'summernote.keyup': function (we, e) {
                        console.log('summernote keyup', we, e);
                    }
                };

                // This method will be called when editor is initialized by $('..').summernote();
                // You can create elements for plugin
                this.initialize = function () {};

                // This methods will be called when editor is destroyed by $('..').summernote('destroy');
                // You should remove elements on `initialize`.
                this.destroy = function () {};
            }
        });
    }));

</script>
<script>
    function bc(id, items, nextItemsUrl) {
        this.id = id;
        this.items = items;
        this.nextItems = [];
        this.nextItemsUrl = nextItemsUrl;
        this.render = function () {
            //console.log(this.items);
            var html = "";
            html += '<nav aria-label="breadcrumb" role="navigation" id="' + id + '_bc">';
            html += '<ol class="breadcrumb">';
            html += '<li class="breadcrumb-item" aria-current="page">root</li>';
            $('#' + id).val('');
            for (var i = 0; i < this.items.length; i++) {
                html += '<li class="breadcrumb-item active" aria-current="page" data-id="' + this.items[i].id + '"><span class="badge badge-info">' + this.items[i].value + '&nbsp;<i class="fa fa-minus-circle" onclick="window[\'' + id + '_bcc\'].remove(\'' + this.items[i].id + '\')"></i></span></li>';
                $('#' + id).val(this.items[i].id);
            }
            if (this.nextItems.length > 0) {
                html += '<li class="breadcrumb-item active" aria-current="page">';
                html += '<select class="form-control-sm" onchange="window[\'' + id + '_bcc\'].add($(this).val(),$(this).find(\'option:selected\').html())">';
                html += ' <option value=""></option>';
                for (var j = 0; j < this.nextItems.length; j++) {
                    html += ' <option value="' + this.nextItems[j].id + '">' + this.nextItems[j].value + '</option>';
                }
                html += '</select>';
                html += '</li>';
            }
            html += '</ol>';
            html += '</nav>';
            $('#' + id).parent().find('#' + id + '_bc').remove();
            $('#' + id).parent().append(html);
        };

        this.add = function (id, value) {
            var value = value.split(' ').join('&nbsp;');
            this.items[this.items.length] = {id: id, value: value};
            this.nextItems = [];
            this.render();
            this.getNextItems();
        };

        this.setNextItems = function (nextItems) {
            this.nextItems = nextItems;
            this.render();
        };

        this.remove = function (id) {
            var newItems = [];
            for (var i = 0; i < this.items.length; i++) {
                if (this.items[i].id == id) {
                    break;
                }
                newItems[newItems.length] = this.items[i];
            }
            this.items = newItems;
            this.render();
            this.getNextItems();
        };

        this.getNextItems = function () {
            var self = this;
            var currentItemId = this.items.length > 0 ? (this.items[this.items.length - 1].id) : '';
            var nextItemsUrl = this.nextItemsUrl + currentItemId;

            $.get(nextItemsUrl).then(function (responseString) {
                var response = JSON.parse(responseString);
                console.log(response)

                if (response.status === "success") {
                    var items = response.data.items;
                    self.setNextItems(items);
                    return;
                }
            }).fail(function (response) {

            }).always(function () {

            });
        };

        console.log(this.items);
        this.render();
        this.getNextItems();
        window[id + '_bcc'] = this;
    }
    $(function () {
        new bc('ParentId', <?php echo json_encode($items); ?>, '<?php echo $nextItemsUrl; ?>');
    });

    $(document).ready(function () {
        $('#Text').summernote({
            placeholder: 'Please, enter page cotent here...',
            tabsize: 2,
            //height: 100,
            fixedToolbar: true,
            callbacks: {
                onChange: function (contents, $editable) {
                    $('input[name=Text]').val(contents);
                }
            }
        });
    });

</script>
@endpush

