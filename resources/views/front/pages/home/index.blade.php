@extends('front.layout.master')

@section("content")
    @if(Auth::guard('web')->check())
        Hola {{Auth::guard('web')->user()->name}}
    @else
        No estás logueado
    @endif
@endsection