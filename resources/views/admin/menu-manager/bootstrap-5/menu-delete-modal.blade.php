<div class="modal fade" id="ModalMenuDelete" tabindex="-1" aria-labelledby="ModalMenuDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalMenuDeleteLabel">
                    Confirm Menu Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this menu?
                </div>
                
                <div class="text-danger">
                    Note! This action cannot be undone.
                </div>

                <form name="FORM_MENU_DELETE" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuDelete(); ?>">
                    <input type="hidden" name="menu_id" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-danger" onclick="FORM_MENU_DELETE.submit();">
                    @include("cms::shared/icons/bootstrap/bi-x-circle")
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmMenuDelete(menu_id) {
        $('#ModalMenuDelete input[name=menu_id]').val(menu_id);
        $('#ModalMenuDelete').modal('show');
    }
</script>
