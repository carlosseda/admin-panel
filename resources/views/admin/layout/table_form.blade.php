@extends('admin.layout.master')

@section('content')

    <div class="topbar-container">
        @include('admin.layout.partials.topbar', ['crud_permissions' => $crud_permissions])
    </div>

    <div class="two-columns">
        <div class="table toggle-table">
            @yield('table')
        </div>

        <div class="form">
            @yield('form')
        </div>
    </div>

@endsection