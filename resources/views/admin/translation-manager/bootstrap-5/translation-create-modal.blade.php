<div class="modal fade" id="ModalTranslationCreate" tabindex="-1" aria-labelledby="                <h5 class="modal-title" id="ModalTranslationCreateLabel">
" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTranslationCreateLabel">
                    New Translation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="FORM_TRANSLATION_CREATE" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationCreate(); ?>">
                    <div class="form-group">
                        <label>Key</label>
                        <input name="Key" value="" class="form-control" />
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-success" onclick="FORM_TRANSLATION_CREATE.submit();">
                    @include("cms::shared/icons/bootstrap/bi-check-circle")
                    Create translation
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showTranslationCreateModal() {
        $('#ModalTranslationCreate').modal('show');
    }
</script>
