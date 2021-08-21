<div class="modal fade" id="ModalBlockDelete" tabindex="-1" aria-labelledby="ModalBlockDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalBlockDeleteLabel">
                    Confirm Block Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this block?
                </div>
                
                <div class="text-danger">
                    Note! This action cannot be undone.
                </div>

                <form name="FormBlockDelete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockDelete(); ?>">
                    <input type="hidden" name="BlockId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" onclick="FormBlockDelete.submit();">
                    @include("cms::shared/icons/bootstrap/bi-x-circle")
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmBlockDelete(blockId) {
        $('#ModalBlockDelete input[name=BlockId').val(blockId);
        $('#ModalBlockDelete').modal('show');
    }
</script>
