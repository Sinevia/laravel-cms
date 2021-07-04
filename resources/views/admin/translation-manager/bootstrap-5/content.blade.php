<div class="box box-primary">
    <div class="box-header with-border">
        <!-- START: Filter -->
        <div class="well hidden-sm hidden-xs">
            <form class="form-inline" name="form_filter" method="get" style="margin:0px;">
                Filter:
                <div class="form-group">
                    <label class="sr-only">Status</label>
                    <select id="filter_status" name="filter_status" class="form-control" onchange="form_filter.submit();">
                        <option value="">- Status -</option>
                        <?php $selected = ($filterStatus != 'Draft') ? '' : ' selected="selected"'; ?>
                        <option value="Draft" <?php echo $selected; ?>>Draft</option>
                        <?php $selected = ($filterStatus != 'Published') ? '' : ' selected="selected"'; ?>
                        <option value="Published" <?php echo $selected; ?>>Published</option>
                        <?php $selected = ($filterStatus != 'Unpublished') ? '' : ' selected="selected"'; ?>
                        <option value="Unpublished" <?php echo $selected; ?>>Unpublished</option>
                    </select>
                </div>

                <button class="btn btn-primary">
                    <span class="glyphicon glyphicon-search"></span>
                </button>

                <button type="button" class="btn btn-primary pull-right" onclick="showTranslationCreateModal();">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    Add Translation
                </button>
            </form>
        </div>
        <!-- END: Filter -->

    </div>

    <div class="box-body">

        <ul class="nav nav-tabs" style="margin-bottom: 3px;">
            <li class="<?php if ($view == '') { ?>active<?php } ?>">
                <a href="?view=all">
                    <span class="glyphicon glyphicon-list"></span> Live
                </a>
            </li>
            <li class="<?php if ($view == 'trash') { ?>active<?php } ?>">
                <a href="?&view=trash">
                    <span class="glyphicon glyphicon-trash"></span> Trash
                </a>
            </li>
        </ul>

        <!--START: Categories -->
        <style scoped="scoped">
            .table-striped > tbody > tr:nth-child(2n+1) > td{
                background-color: transparent !important;
            }
            .table-striped > tbody > tr:nth-child(2n+1){
                background-color: #F9F9F9 !important;
            }
            #table_articles tr:hover {
                background-color: #FEFF8F !important;
            }
        </style>
        <table id="table_articles" class="table table-striped">
            <tr>
                <th style="text-align:center;">
                    <a href="?cmd=pages-manager&amp;by=Key&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Translation Key&nbsp;<?php
                        if ($orderby === 'Title') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>,
                    <a href="?cmd=pages-manager&amp;by=id&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        ID&nbsp;<?php
                        if ($orderby === 'Id') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>
                </th>
                <th style="text-align:center;width:100px;">
                    <a href="?cmd=pages-manager&amp;by=UpdatedAt&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Modified&nbsp;<?php
                        if ($orderby === 'Status') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>
                </th>
                <th style="text-align:center;width:160px;">Action</th>
            </tr>

            <?php foreach ($translationKeys as $translationKey) { ?>
                <?php
                $key = $translationKey->Key;
                $updatedAt = date('d M Y',strtotime($translationKey->UpdatedAt));
                $idLanguage = Sinevia\Cms\Models\TranslationValue::where('KeyId',$translationKey->Id)->get(['Language'])->toArray();
                $languages = array_column($idLanguage, 'Language');
                ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;font-weight:bold;">
                            <?php echo htmlentities($key); ?>
                        </div>
                        <div style="color:#333;font-size: 11px;">
                            Translations <?php echo count($languages); ?>: <?php echo htmlentities(implode(', ', $languages)); ?>
                        </div>
                    </td>
                    <td style="text-align:center;vertical-align: middle;font-size: 12px;">
                        <?php echo $updatedAt; ?><br>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <a class="btn btn-xs btn-warning" href="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationUpdate(['TranslationId' => $translationKey['Id']]); ?>">
                            <span class="glyphicon glyphicon-edit"></span>
                            Edit
                        </a>

                        <button class="btn btn-xs btn-danger" onclick="confirmTranslationDelete('<?php echo $translationKey->Id; ?>');">
                            <span class="glyphicon glyphicon-remove-sign"></span>
                            Delete
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->    
        {!! $translationKeys->render() !!}
        <!-- END: Pagination -->
    </div>

</div>


<!-- START: Translation Create Modal Dialog -->
<div class="modal fade" id="ModalTranslationCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>New Translation</h3>
            </div>
            <div class="modal-body">
                <form name="FormTranslationCreate" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationCreate(); ?>">
                    <div class="form-group">
                        <label>Key</label>
                        <input name="Key" value="" class="form-control" />
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-success" data-dismiss="modal" onclick="FormTranslationCreate.submit();">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    Create translation
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function showTranslationCreateModal() {
        $('#ModalTranslationCreate').modal('show');
    }
</script>
<!-- END: Translation Create Modal Dialog -->


<!-- START: Translation Delete Modal Dialog -->
<div class="modal fade" id="ModalTranslationDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Confirm Translation Delete</h3>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this template?
                </div>
                <div>
                    Note! This action cannot be undone.
                </div>

                <form name="FormTranslationDelete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminTranslationDelete(); ?>">
                    <input type="hidden" id="template_delete_id" name="TranslationId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-danger" data-dismiss="modal" onclick="FormTranslationDelete.submit();">
                    <span class="glyphicon glyphicon-remove-sign"></span>
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmTranslationDelete(template_id) {
        $('#ModalTranslationDelete input[name=TranslationId]').val(template_id);
        $('#ModalTranslationDelete').modal('show');
    }
</script>
<!-- END: Translation Delete Modal Dialog -->
