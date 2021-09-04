<div class="modal fade" id="ModalMenuMoveToTrash" tabindex="-1" aria-labelledby="ModalMenuMoveToTrashLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalMenuMoveToTrashLabel">
                    Confirm Menu Move to Trash
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to move this menu to trash?
                </div>

                <form name="FORM_MENU_MOVE_TO_TRASH" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuMoveToTrash(); ?>">
                    <input type="hidden" name="menu_id" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-warning" onclick="FORM_MENU_MOVE_TO_TRASH.submit();">
                    @include("cms::shared/icons/bootstrap/bi-trash")
                    Move to Trash
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmMenuMoveToTrash(menuId) {
        $('#ModalMenuMoveToTrash input[name=menu_id]').val(menuId);
        $('#ModalMenuMoveToTrash').modal('show');
    }
</script>
