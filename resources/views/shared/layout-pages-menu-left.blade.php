@extends('knowledge::layout')

@section('title', 'Home')

@section('content')
<div style="background:white;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h3>
                    Pages
                    <button onclick="showPageCreateDialog();" class="btn btn-primary float-right">
                        <i class="fa fa-plus"></i>
                        page
                    </button>
                </h3>
                @include('knowledge::shared/page-menu')
            </div>
            <div class="col-sm-10">
                @yield('page-content')                
            </div>
        </div>
    </div>
</div>
@endsection