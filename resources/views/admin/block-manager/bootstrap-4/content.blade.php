<div class="box box-primary">
    <div class="box-header with-border">
        <!-- START: Filter -->
        <div class="well">
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

                <button type="button" class="btn btn-primary pull-right" onclick="showBlockCreateModal();">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    Add Block
                </button>
            </form>
        </div>
        <!-- END: Filter -->

    </div>

    <div class="box-body">

        <ul class="nav nav-tabs" style="margin-bottom: 3px;">
            <li class="<?php if ($view == '' OR $view == 'all') { ?>active<?php } ?>">
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
                    <a href="?by=Title&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Title&nbsp;<?php
                        if ($orderby === 'Title') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>,
                    <a href="?by=Id&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
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
                    <a href="?by=Status&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Status&nbsp;<?php
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

            <?php foreach ($blocks as $block) { ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;">
                            <?php echo $block->Title; ?>
                        </div>
                        <div style="color:#999;font-size: 10px;">
                            <?php echo $block->Id; ?>
                        </div>
                    <td style="text-align:center;vertical-align: middle;">
                        <?php echo $block->Status; ?><br>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockUpdate(['BlockId' => $block->Id]); ?>" class="btn btn-sm btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Edit
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="confirmBlockDelete('<?php echo $block->Id; ?>');">
                            <span class="glyphicon glyphicon-remove-sign"></span>
                            Delete
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->
        <?php echo $blocks->render(); ?>
        <!-- END: Pagination -->
    </div>

</div>

<!-- START: Block Create Modal Dialog -->
<div class="modal fade" id="ModalBlockCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>New Block</h3>
            </div>
            <div class="modal-body">
                <form name="FormBlockCreate" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockCreate(); ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="Title" value="" class="form-control" />
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-success" data-dismiss="modal" onclick="FormBlockCreate.submit();">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    Create Block
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function showBlockCreateModal() {
        $('#ModalBlockCreate').modal('show');
    }
</script>
<!-- END: Block Create Modal Dialog -->


<!-- START: Block Delete Modal Dialog -->
<div class="modal fade" id="ModalBlockDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Confirm Block Delete</h3>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this block?
                </div>
                <div>
                    Note! This action cannot be undone.
                </div>

                <form name="FormBlockDelete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminBlockDelete(); ?>">
                    <input type="hidden" name="BlockId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-danger" data-dismiss="modal" onclick="FormBlockDelete.submit();">
                    <span class="glyphicon glyphicon-remove-sign"></span>
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
<!-- END: Block Delete Modal Dialog -->
