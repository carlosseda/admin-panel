@if($agent->isDesktop())
    <link href="{{mix('admin/desktop/css/app.css')}}" rel="stylesheet">
@endif

@if($agent->isMobile())
    <link href="{{mix('admin/mobile/css/app.css')}}" rel="stylesheet">
@endif


