<div class="about-us">

    <div class="two-columns">
        <div class="about-us-element">
            <div class="about-us-title">
                <h3>@lang('front/about_us.ourbusiness-title')</h3>
            </div>
            <div class="about-us-text">
                @lang('front/information.ourbusiness')
            </div>
        </div>

        <div class="about-us-element">
            <div class="about-us-image">
                @if($agent->isDesktop())
                    <img src="{{Storage::url($business->image_our_business_desktop->path)}}" alt="{{$business->image_our_business_desktop->alt}}" title="{{$business->image_our_business_desktop->title}}">
                @endif
            
                @if($agent->isMobile())
                    <img src="{{Storage::url($business->image_our_business_mobile->path)}}" alt="{{$business->image_our_business_mobile->alt}}" title="{{$business->image_our_business_mobile->title}}">
                @endif
            </div>
        </div>
    </div>

    <div class="two-columns">
        <div class="about-us-element">
            <div class="about-us-image">
                @if($agent->isDesktop())
                    <img src="{{Storage::url($business->image_our_fleet_desktop->path)}}" alt="{{$business->image_our_fleet_desktop->alt}}" title="{{$business->image_our_fleet_desktop->title}}">
                @endif
            
                @if($agent->isMobile())
                    <img src="{{Storage::url($business->image_our_fleet_mobile->path)}}" alt="{{$business->image_our_fleet_mobile->alt}}" title="{{$business->image_our_fleet_mobile->title}}">
                @endif
            </div>
        </div>

        <div class="about-us-element">
            <div class="about-us-title">
                <h3>@lang('front/about_us.ourfleet-title')</h3>
            </div>
            <div class="about-us-text">
                @lang('front/information.ourfleet')
            </div>
        </div>
    </div>
    
</div>
