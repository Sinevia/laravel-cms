<div class="modal fade" id="ModalTemplateDelete" tabindex="-1" aria-labelledby="ModalTemplateDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTemplateDeleteLabel">
                    Confirm Template Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this template?
                </div>
                
                <div class="text-danger">
                    Note! This action cannot be undone.
                </div>

                <form name="FORM_TEMPLATE_DELETE" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateDelete(); ?>">
                    <input type="hidden" id="template_delete_id" name="TemplateId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-danger" onclick="FORM_TEMPLATE_DELETE.submit();">
                    @include("cms::shared/icons/bootstrap/bi-x-circle")
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmTemplateDelete(template_id) {
        $('#ModalTemplateDelete input[name=TemplateId]').val(template_id);
        $('#ModalTemplateDelete').modal('show');
    }
</script>
