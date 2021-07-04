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

                <button type="button" class="btn btn-primary pull-right" onclick="showWidgetCreateModal();">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    Add Widget
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

            <?php foreach ($widgets as $widget) { ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;">
                            <?php echo $widget->Title; ?>
                        </div>
                        <div style="color:#999;font-size: 10px;">
                            <?php echo $widget->Id; ?>
                        </div>
                    <td style="text-align:center;vertical-align: middle;">
                        <?php echo $widget->Status; ?><br>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetUpdate(['WidgetId'=>$widget->Id]); ?>" class="btn btn-sm btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Edit
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="confirmWidgetDelete('<?php echo $widget->Id; ?>');">
                            <span class="glyphicon glyphicon-remove-sign"></span>
                            Delete
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->
        <?php echo $widgets->render(); ?>
        <!-- END: Pagination -->
    </div>

</div>

<!-- START: Widget Create Modal Dialog -->
<div class="modal fade" id="ModalWidgetCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>New Widget</h3>
            </div>
            <div class="modal-body">
                <form name="FormWidgetCreate" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetCreate(); ?>">
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
                <a id="modal-close" href="#" class="btn btn-success" data-dismiss="modal" onclick="FormWidgetCreate.submit();">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    Create widget
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function showWidgetCreateModal() {
        $('#ModalWidgetCreate').modal('show');
    }
</script>
<!-- END: Widget Create Modal Dialog -->


<!-- START: Widget Delete Modal Dialog -->
<div class="modal fade" id="ModalWidgetDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Confirm Widget Delete</h3>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this template?
                </div>
                <div>
                    Note! This action cannot be undone.
                </div>

                <form name="FormWidgetDelete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetDelete(); ?>">
                    <input type="hidden" id="template_delete_id" name="WidgetId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-danger" data-dismiss="modal" onclick="FormWidgetDelete.submit();">
                    <span class="glyphicon glyphicon-remove-sign"></span>
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmWidgetDelete(template_id) {
        $('#template_delete_id').val(template_id);
        $('#ModalWidgetDelete').modal('show');
    }
</script>
<!-- END: Widget Delete Modal Dialog -->

<br />
<br />
<br />
