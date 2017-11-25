@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
        @yield('page')
    </div>
@endsection
