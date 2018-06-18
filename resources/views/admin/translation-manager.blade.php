<?php if (View::exists(config('cms.layout-master'))) { ?>
    @extends(config('cms.layout-master'))
<?php } ?>

@section('webpage_title', 'Translation Manager')

@section('webpage_header')
<h1>
    Page Manager
    <button type="button" class="btn btn-primary pull-right" onclick="showTranslationCreateModal();">
        <span class="glyphicon glyphicon-plus-sign"></span>
        Add Translation
    </button>
</h1>
<ol class="breadcrumb">
    <li><a href="<?php echo \Sinevia\Cms\Helpers\Links::adminHome(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">CMS</a></li>
    <li class="active"><a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageManager(); ?>">Translations</a></li>
</ol>
@stop

@section('webpage_content')

@include('cms::shared.navigation')

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

                <button type="button" class="btn btn-primary pull-right" onclick="showPageCreateModal();">
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

            <?php foreach ($translationKeys as $translationKey) { ?>
                <?php
                $key = $translationKey->Key;
                $updatedAt = $translationKey->UpdatedAt;
                ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;font-weight:bold;">
                            <?php echo htmlentities($key); ?>
                        </div>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <?php echo $updatedAt; ?><br>
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
        {!! $translationKeys->render() !!}
        <!-- END: Pagination -->
    </div>

</div>


@stop
