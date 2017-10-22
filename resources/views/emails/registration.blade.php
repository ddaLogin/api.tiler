@extends('layouts.email')

@section('content')
    <div class="container text-center">
        <h3>Hello, {{$user->surname}} {{$user->name}}</h3>
        <h4>Welcome to the <a href="{{route('home')}}">Tiler</a></h4>
        <hr>
        <p>Please confirm your e-mail</p>
        <a href="#" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
            Confirm
        </a>
        <hr>
        <p>If you have not registered on our website, just ignore this email.</p>
    </div>
@endsection
