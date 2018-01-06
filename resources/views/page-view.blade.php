@extends('knowledge::shared.layout-pages-menu-left')

@section('title', $page->Title)

@section('page-content')
<nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb">
        <?php foreach ($pathArray as $p) { ?>
            <li class="breadcrumb-item">
                <a href="<?php echo $p->Url; ?>">{{$p->Title}}</a>
            </li>
        <?php } ?>
    </ol>
</nav>

<h1>
    {!! $page->Title !!}
    <a href="{{$pageUpdateUrl}}" class="btn btn-primary float-right">Edit</a>
</h1>

{!! $page->Text !!}

@include('knowledge::page-create-modal')

@stop