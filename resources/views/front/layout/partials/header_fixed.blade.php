<header class="partial header-fixed fixed">

    <div class="header-container">
        <div class="header-logo">
            @isset($logo->path)
                <a href="/"><img src="{{Storage::url($logo->path)}}" alt="{{$logo->alt}}" title="{{$logo->title}}"></a>
            @endisset
        </div>
    
        <div class="header-menu">
            {{display_menu('principal','horizontal')}}

            <div class="booking-button">
                <button>
                    @lang('front/header.booking')
                </button>
            </div>
        </div>
    </div>

</header>

<div class="header-checkpoint"></div>
