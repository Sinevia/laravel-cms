<div class="card box-primary">
    <div class="card-header with-border">
        <!-- START: Filter -->
        <div class="well">
            <form name="form_filter" method="get" style="margin:0px;">
                <div class="row">
                    <div class="col-sm-1">
                        Filter:
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="sr-only">Status</label>
                            <select id="filter_status" name="filter_status" class="form-control" onchange="form_filter.submit();">
                                <option value="">- Status -</option>
                                <?php $selected = ($filterStatus != 'draft') ? '' : ' selected="selected"'; ?>
                                <option value="Draft" <?php echo $selected; ?>>Draft</option>
                                <?php $selected = ($filterStatus != 'active') ? '' : ' selected="selected"'; ?>
                                <option value="Published" <?php echo $selected; ?>>Published</option>
                                <?php $selected = ($filterStatus != 'disabled') ? '' : ' selected="selected"'; ?>
                                <option value="Unpublished" <?php echo $selected; ?>>Unpublished</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input id="filter_search" name="filter_search" class="form-control" value="{{$filterSearch}}" placeholder="Search by name" />
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" title="Filter">
                            @include("cms::shared.icons.bootstrap.bi-filter")
                        </button>

                        <button type="button" class="btn btn-primary float-end" onclick="showMenuCreateModal();">
                            @include("cms::shared.icons.bootstrap.bi-plus-circle")
                            Add Menu
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
                <a class="nav-link <?php if ($view == '' || $view == 'all') { ?>active<?php } ?>"  href="?view=all">
                    @include("cms::shared/icons/bootstrap/bi-list")
                    Live
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($view == 'trash') { ?>active<?php } ?>" href="?&view=trash">
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
            #table_pages tr:hover {
                background-color: #FEFF8F !important;
            }
        </style>
        <table id="table_pages" class="table table-striped">
            <tr>
                <th style="text-align:center;">
                    <a href="?cmd=pages-manager&amp;by=Title&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Title&nbsp;<?php
                        if ($orderby === 'Title') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>,
                    <a href="?by=id&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        ID&nbsp;<?php
                        if ($orderby === 'id') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>
                </th>
                <th style="text-align:center;width:100px;">
                    <a href="?cmd=pages-manager&amp;by=Status&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Status&nbsp;<?php
                        if ($orderby === 'Status') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>
                </th>
                <th style="width:120px;">
                    Menu Items
                </th>

                <th style="text-align:center;width:230px;">
                    Action
                </th>
            </tr>

            <?php foreach ($menus as $menu) { ?>
                <?php $menuItemsCount = $menu->menuitems->count(); ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;font-weight:bold;">
                            <?php echo $menu->Title; ?>
                        </div>
                        <div style="color:#999;font-size: 10px;">
                            ref. <?php echo $menu->Id; ?>
                        </div>
                    <td style="text-align:center;vertical-align: middle;">
                        <?php echo ucfirst($menu['Status']); ?><br>
                    </td>
                    <td style="text-align:center;">
                        {{ $menuItemsCount }}
                        <br />
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuitemManager(['menu_id' => $menu['Id']]); ?>" style="text-decoration:underline;">
                            Manage
                        </a>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuUpdate(['menu_id' => $menu['Id']]); ?>" class="btn btn-sm btn-warning">
                            @include("cms::shared/icons/bootstrap/bi-pencil-square")
                            Edit
                        </a>

                        <?php if ($menu->Status == \Sinevia\Cms\Models\Menu::STATUS_DELETED) { ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmMenuDelete('<?php echo $menu->Id; ?>');">
                                @include("cms::shared/icons/bootstrap/bi-x-circle")
                                Delete
                            </button>
                        <?php } ?>

                        <?php if ($menu->Status != \Sinevia\Cms\Models\Menu::STATUS_DELETED) { ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmMenuMoveToTrash('<?php echo $menu->Id; ?>');">
                                @include("cms::shared/icons/bootstrap/bi-trash")
                                Trash
                            </button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->
        <?= $menus->appends(request()->all())->render() ?>
        <!-- END: Pagination -->
    </div>

</div>


@include('cms::admin/menu-manager/bootstrap-5/menu-create-modal')
@include('cms::admin/menu-manager/bootstrap-5/menu-delete-modal')
@include('cms::admin/menu-manager/bootstrap-5/menu-move-trash-modal')
