<?php /** @var \App\Models\Category[] $categories */ ?>
<?php /** @var \App\Models\Category $category */ ?>
@extends('layouts.admin')

@section('page')
    <div class="panel panel-default">
        <div class="panel-heading"><i class="mdi mdi-view-list"></i> Categories</div>
        <div class="panel-body">
            <a href="{{route('admin.categories.create')}}" class="btn btn-primary">
                <i class="mdi mdi-plus-box"></i> New category
            </a>
            <br><br>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Publications count</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <th>{{$category->id}}</th>
                        <td>{{$category->name}}</td>
                        <td>{{$category->posts_count}}</td>
                        <td>
                            <a href="{{route('admin.categories.edit', $category->id)}}" class="btn btn-primary btn-xs"><i class="mdi mdi-pencil"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
