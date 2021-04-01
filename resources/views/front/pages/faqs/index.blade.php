@extends('front.layout.master')

@section("content")
    @if($agent->isDesktop())
        <div class="page-section">
            @include("front.pages.faqs.desktop.faqs")
        </div>
    @endif

    @if($agent->isMobile())
        <div class="page-section">
            @include("front.pages.faqs.mobile.faqs")
        </div>
    @endif
@endsection
        
        