@extends('front.layout.master')

@section('title')@lang('front/seo.web-name') | {{$seo->title}} @stop
@section('description'){{$seo->description}} @stop
@section('keywords'){{$seo->keywords}} @stop
@section('facebook-url'){{URL::asset('/' . $seo->url)}} @stop
@section('facebook-title'){{$seo->title}} @stop
@section('facebook-description'){{$seo->description}} @stop

@section("content")

    @if($agent->isDesktop())
        <div class="page-section">
            @include("front.components.desktop.page_header", ['title' => trans('front/contact.title')])
            @include("front.pages.contact.desktop.contact")
        </div>
    @endif

    @if($agent->isMobile())
        <div class="page-section">
            @include("front.pages.contact.mobile.contact")
        </div>
    @endif
@endsection
        
        