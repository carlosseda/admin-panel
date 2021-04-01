@if($agent->isDesktop())
    <link href="{{mix('front/desktop/css/app.css')}}" rel="stylesheet">
@endif

@if($agent->isMobile())
    <link href="{{mix('front/mobile/css/app.css')}}" rel="stylesheet">
@endif
