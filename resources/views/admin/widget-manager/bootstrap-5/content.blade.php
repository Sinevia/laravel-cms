<div class="box box-primary">
    <div class="box-header with-border">
        <!-- START: Filter -->
        <div class="well hidden-sm hidden-xs">
            <form class="form-inline" name="form_filter" method="get" style="margin:0px;">
                <div class="row">
                    <div class="col-sm-1">
                        Filter:
                    </div>
                    <div class="col-sm-2">
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
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" title="Filter">
                            @include("cms::shared.icons.bootstrap.bi-filter")
                        </button>

                        <button type="button" class="btn btn-primary float-end" onclick="showWidgetCreateModal();">
                            @include("cms::shared.icons.bootstrap.bi-plus-circle")
                            Add Widget
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- END: Filter -->

    </div>

    <div class="box-body">

        <ul class="nav nav-tabs" style="margin-bottom: 3px;">
            <li class="nav-item">
                <a href="?view=all" class="nav-link <?php if ($view == '' OR $view == 'all') { ?>active<?php } ?>">
                    @include("cms::shared/icons/bootstrap/bi-list")
                    Live
                </a>
            </li>
            <li class="nav-item">
                <a href="?&view=trash" class="nav-link <?php if ($view == 'trash') { ?>active<?php } ?>">
                    @include("cms::shared/icons/bootstrap/bi-trash")
                    Trash
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
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminWidgetUpdate(['WidgetId' => $widget->Id]); ?>" class="btn btn-sm btn-warning">
                            @include("cms::shared/icons/bootstrap/bi-pencil-square")
                            Edit
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="confirmWidgetDelete('<?php echo $widget->Id; ?>');">
                            @include("cms::shared/icons/bootstrap/bi-x-circle")
                            Delete
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->
        <?php echo $widgets->render("cms::shared/bootstrap-5/pagination"); ?>
        <!-- END: Pagination -->
    </div>

</div>



<br />
<br />
<br />

@include('cms::admin/widget-manager/bootstrap-5/widget-create-modal')
@include('cms::admin/widget-manager/bootstrap-5/widget-delete-modal')
