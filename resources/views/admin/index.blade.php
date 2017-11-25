@extends('layouts.admin')

@section('page')
    <div class="row">
        <div class="col col-sm-2 text-center">
            <a href="{{route('admin.users.index')}}">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <i class="mdi mdi-account-multiple mdi-48px"></i>
                        <h3 class="mt-0 mb-0">Users</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col col-sm-2 text-center">
            <a href="{{route('admin.categories.index')}}">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <i class="mdi mdi-view-list mdi-48px"></i>
                        <h3 class="mt-0 mb-0">Categories</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
