@extends('admin.layout.master')

@section('content')

    <div class="table active" id="table" data-pagination="{{$pagination}}" data-lastpage="{{$last_page}}">
        @yield('table')
    </div>

    <div class="form" id="form">
        @yield('form')
    </div>

@endsection