<div class="modal fade" id="ModalTemplateCreate" tabindex="-1" aria-labelledby="ModalTemplateCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTemplateCreateLabel">
                    New Template
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="FORM_TEMPLATE_CREATE" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTemplateCreate(); ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="Title" value="" class="form-control" />
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-success" onclick="FORM_TEMPLATE_CREATE.submit();">
                    @include("cms::shared/icons/bootstrap/bi-check-circle")
                    Create template and edit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showTemplateCreateModal() {
        $('#ModalTemplateCreate').modal('show');
    }
</script>
