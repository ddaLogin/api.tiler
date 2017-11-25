<?php /** @var \App\Models\Category $category */ ?>
@extends('layouts.admin')

@section('page')
    <div class="col col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if($category->exists)
                    <i class="mdi mdi-pencil"></i> {{$category->name}}
                @else
                    <i class="mdi mdi-plus-box"></i> New category
                @endif
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ ($category->exists)? route('admin.categories.update', $category->id) : route('admin.categories.store') }}">
                    {{method_field(($category->exists)?'PUT':'POST')}}
                    {{csrf_field()}}
                    <div class="form-group {{($errors->has('name'))?'has-error':''}}">
                        <label class="control-label" for="inputSuccess1">Category name</label>
                        <input name="name" type="text" class="form-control" value="{{old('name')??$category->name}}" placeholder="Name">
                        @if($errors->has('name'))
                            <span id="helpBlock2" class="help-block">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success pull-right">
                        <i class="mdi mdi-content-save"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
