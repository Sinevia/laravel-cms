@extends('knowledge::layout')

@section('title', 'Home')

@section('content')
<div style="background:white;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                MENU
                <div class="tree well">
                    <ul>
                        <li>
                            <span>
                                <i class="fa fa-folder-open"></i> Parent
                            </span>
                            <ul>
                                <li>
                                    <span><i class="fa fa-minus"></i> Child</span>
                                    <ul>
                                        <li>
                                            <span><i class="fa-file"></i> Grand Child</span>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span><i class="fa-folder-open"></i> Parent2</span>
                            <ul>
                                <li>
                                    <span><i class="fa-file"></i> Child</span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                CONTENT
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
<script>
    $(function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus').removeClass('fa-minus');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus').removeClass('fa-plus');
            }
            e.stopPropagation();
        });
    });
</script>

@stop

