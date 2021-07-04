<div class="modal fade" id="ModalTemplateMoveToTrash" tabindex="-1" aria-labelledby="ModalTemplateMoveToTrashLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTemplateMoveToTrashLabel">
                    Confirm Template Move to Trash
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to move this template to trash?
                </div>

                <form name="FORM_TEMPLATE_MOVE_TO_TRASH" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateMoveToTrash(); ?>">
                    <input type="hidden" id="template_delete_id" name="TemplateId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-warning" onclick="FORM_TEMPLATE_MOVE_TO_TRASH.submit();">
                    @include("cms::shared/icons/bootstrap/bi-trash")
                    Move to Trash
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmTemplateMoveToTrash(template_id) {
        $('#ModalTemplateMoveToTrash input[name=TemplateId]').val(template_id);
        $('#ModalTemplateMoveToTrash').modal('show');
    }
</script>
