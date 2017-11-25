<?php /** @var \App\Models\User[] $users */ ?>
<?php /** @var \App\Models\User $user */ ?>
@extends('layouts.admin')

@section('page')
    <div class="panel panel-default">
        <div class="panel-heading"><i class="mdi mdi-account-multiple"></i> Users</div>
        <div class="panel-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Surname</th>
                    <th>Name</th>
                    <th>E-mail</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{$user->id}}</th>
                        <td>{{$user->surname}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col col-sm-3">
                    <form action="#" method="GET">
                        <div class="input-group">
                            <input type="number" name="size" value="{{$size}}" class="form-control" placeholder="Count per page">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col col-sm-9 paginate-margin-disable">
                    {!! $users->appends(['size' => $size])->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
