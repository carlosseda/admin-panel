@extends('admin.layout.master')

@section('content')

    <div class="two-columns">
        <div class="table" id="table">
            @yield('table')
        </div>

        <div class="form" id="form">
            @yield('form')
        </div>
    </div>

@endsection