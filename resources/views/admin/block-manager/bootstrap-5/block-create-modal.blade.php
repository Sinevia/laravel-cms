<div class="modal fade" id="ModalBlockCreate" tabindex="-1" aria-labelledby="ModalBlockCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalBlockCreateLabel">
                    New Block
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="FORM_BLOCK_CREATE" method="POST" action="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockCreate(); ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="Title" value="" class="form-control" placeholder="Enter block title" />
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-success" onclick="FORM_BLOCK_CREATE.submit();">
                    @include("cms::shared/icons/bootstrap/bi-check-circle")
                    Create block and edit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showBlockCreateModal() {
        $('#ModalBlockCreate').modal('show');
    }
</script>
