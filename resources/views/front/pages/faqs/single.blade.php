@extends('front.layout.master')

@section('title')@lang('front/seo.web-name') | {{$faq->seo->title}} @stop
@section('description'){{$faq->seo->description}} @stop
@section('keywords'){{$faq->seo->keywords}} @stop
@section('facebook-url'){{URL::asset('/faqs/' . $faq->seo->slug)}} @stop
@section('facebook-title'){{$faq->seo->title}} @stop
@section('facebook-description'){{$faq->seo->description}} @stop

@section("content")
    @if($agent->isDesktop())
        <div class="page-section">
            @include("front.pages.faqs.desktop.faq")
        </div>
    @endif

    @if($agent->isMobile())
        <div class="page-section">
            @include("front.pages.faqs.mobile.faq")
        </div>
    @endif
@endsection
        
        