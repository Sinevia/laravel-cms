<?php
//$typeList = \App\Models\Pets\Pet::$typeList;
//$ownerList = App\Models\Customers\Customer::active()->get();
?>
<!-- START: Page Create Dialog -->
<div class="modal fade" id="ModalPageCreate" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="FormPageCreate">
                    <div class="alert alert-success" style="display:none;"></div>
                    <div class="alert alert-danger" style="display:none;"></div>
                    <div class="form-group">
                        <label>
                            Title <sup style="color:red;">*</sup>
                        </label>
                        <input name="Title" value="" class="form-control" />
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-info float-left" data-dismiss="modal">
                    Cancel
                </a>
                <button class="btn btn-success" onclick="formPageCreateSubmit();">
                    Continue
                    <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showPageCreateDialog(options) {
        //var options = (typeof options === 'undefined') ? {} : options;
        //var ownerId = (typeof options['OwnerId'] === 'undefined') ? '' : $.trim(options['OwnerId']);
        //$('#ModalPageCreate input[name=PageId]').val(pageId)
        $('#ModalPageCreate').modal('show');
    }
    function formPageCreateSubmit(options) {
        var pageCreateUrl = '<?php echo action('\Sinevia\Knowledge\Controllers\KnowledgeController@anyPageCreateAjax'); ?>';
        var pageViewUrl = '<?php echo action('\Sinevia\Knowledge\Controllers\KnowledgeController@anyView'); ?>';
        var data = $('.FormPageCreate :input').serialize();
        $('#ModalPageCreate button .fa-spinner').show();

        $('#ModalPageCreate .alert-success').fadeOut().html('');
        $('#ModalPageCreate .alert-danger').fadeOut().html('');

        $.post(pageCreateUrl, data).then(function (responseString) {
            var response = JSON.parse(responseString);
            console.log(response)

            if (response.status === "success") {
                var pageId = response.data.PageId;
                var messages = response.message;
                $('.FormPageCreate .alert-success').fadeIn().html(messages);
                window.location.href = pageViewUrl + '/' + pageId;
                return;
            }

            if (response.status === "error") {
                var messages = response.message;
                messages = $.isArray(messages) ? messages.join('<br />') : messages;
                $('.FormPageCreate .alert-danger').fadeIn().html(messages);
                return;
            }
        }).fail(function (response) {
            $('.FormPageCreate .alert-danger').fadeIn().html('There was server error. Please try again later');
        }).always(function () {
            $('#ModalPageCreate button .fa-spinner').hide();
        });
    }
</script>
<!-- END: Pet Create Dialog -->