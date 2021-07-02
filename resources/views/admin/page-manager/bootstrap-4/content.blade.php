<div class="box box-primary">
    <div class="box-header with-border">
        <!-- START: Filter -->
        <div class="well">
            <form class="form-inline" name="form_filter" method="get" style="margin:0px;">
                Filter:
                &nbsp;
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
                &nbsp;
                <div class="form-group">
                    <input id="filter_search" name="filter_search" class="form-control" value="{{$filterSearch}}" />
                </div>

                <button class="btn btn-primary">
                    <span class="glyphicon glyphicon-filter"></span>
                </button>

                <button type="button" class="btn btn-primary float-right" onclick="showPageCreateModal();">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    Add Page
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
                    <a href="?cmd=pages-manager&amp;by=Title&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Title&nbsp;<?php
                        if ($orderby === 'Title') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>,
                    <a href="?cmd=pages-manager&amp;by=Alias&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Alias&nbsp;<?php
                        if ($orderby === 'Alias') {
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
                <th style="text-align:center;width:160px;">Action</th>
            </tr>

            <?php foreach ($pages as $page) { ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;font-weight:bold;">
                            <?php echo $page->Title; ?>
                        </div>                        
                        <div style="color:#333;font-size: 12px;font-style:italic;">
                            <?php echo $page->Alias; ?>
                        </div>
                        <div style="color:#999;font-size: 10px;">
                            ref. <?php echo $page->Id; ?>
                        </div>
                    <td style="text-align:center;vertical-align: middle;">
                        <?php echo $page['Status']; ?><br>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <a href="<?php echo $page->url(); ?>" class="btn btn-sm btn-success" target="_blank">
                            <span class="glyphicon glyphicon-eye-open"></span>
                            View
                        </a>
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageUpdate(['PageId' => $page['Id']]); ?>" class="btn btn-sm btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                            Edit
                        </a>

                        <?php if ($page->Status == 'Deleted') { ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmPageDelete('<?php echo $page->Id; ?>');">
                                <span class="glyphicon glyphicon-remove-sign"></span>
                                Delete
                            </button>
                        <?php } ?>

                        <?php if ($page->Status != 'Deleted') { ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmPageMoveToTrash('<?php echo $page->Id; ?>');">
                                <span class="glyphicon glyphicon-trash"></span>
                                Trash
                            </button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->    
        {!! $pages->render() !!}
        <!-- END: Pagination -->
    </div>

</div>

<!-- START: Page Create Modal Dialog -->
<div class="modal fade" id="ModalPageCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>New Page</h3>
            </div>
            <div class="modal-body">
                <form name="FormPageCreate" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminPageCreate(); ?>">
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
                <a id="modal-close" href="#" class="btn btn-success" data-dismiss="modal" onclick="FormPageCreate.submit();">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    Create page
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function showPageCreateModal() {
        $('#ModalPageCreate').modal('show');
    }
</script>
<!-- END: Page Create Modal Dialog -->


<!-- START: Page Delete Modal Dialog -->
<div class="modal fade" id="ModalPageDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Confirm Page Delete</h3>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to delete this page?
                </div>
                <div>
                    Note! This action cannot be undone.
                </div>

                <form name="FormPageDelete" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminPageDelete(); ?>">
                    <input type="hidden" name="PageId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-danger" data-dismiss="modal" onclick="FormPageDelete.submit();">
                    <span class="glyphicon glyphicon-remove-sign"></span>
                    Delete Page
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmPageDelete(page_id) {
        $('#ModalPageDelete input[name=PageId]').val(page_id);
        $('#ModalPageDelete').modal('show');
    }
</script>
<!-- END: Page Delete Modal Dialog -->

<!-- START: Page Move to Trash Modal Dialog -->
<div class="modal fade" id="ModalPageMoveToTrash">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Confirm Page Move to Trash</h3>
            </div>
            <div class="modal-body">
                <div>
                    Are you sure you want to move this page to trash?
                </div>

                <form name="FormPageMoveToTrash" method="post" action="<?php echo \Sinevia\Cms\Helpers\Links::adminPageMoveToTrash(); ?>">
                    <input type="hidden" name="PageId" value="">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <a id="modal-close" href="#" class="btn btn-info pull-left" data-dismiss="modal">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-danger" data-dismiss="modal" onclick="FormPageMoveToTrash.submit();">
                    <span class="glyphicon glyphicon-trash"></span>
                    Move to Trash
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmPageMoveToTrash(pageId) {
        $('#ModalPageMoveToTrash input[name=PageId]').val(pageId);
        $('#ModalPageMoveToTrash').modal('show');
    }
</script>
<!-- END: Page Move to Trash Modal Dialog -->
