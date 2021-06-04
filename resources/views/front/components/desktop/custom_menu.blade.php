@if(!isset($innerLoop))
<ul class="{{$type == 'horizontal' ? 'menu-inline':''}} {{$type == 'vertical' ? 'menu-vertical':''}}">
@else
<ul class="menu">
@endif

@foreach ($items->sortBy('order') as $item)

    @if(isset($item->url) || isset($item->custom_url))

            @if(isset($item->url))
            
            <li class="deeper parent {{strpos(Request::url(), route($item->custom_url)) !== false ? 'selected' : ''}}">

                <a href="{{route($item->custom_url)}}">
                    <h4>{{ $item->name }}</h4>
                </a>
            @endif

            @if(isset($item->custom_url))

            <li class="deeper parent">

                <a href="{{$item->custom_url}}">
                    <h4>{{ $item->name }}</h4>
                </a>
            @endif

            @if(!$item->children->isEmpty())
                @include('front.components.desktop.custom_menu', ['items' => $item->children, 'innerLoop' => true])
            @endif
            
        </li>
    @endif

@endforeach

{{-- <li class="deeper parent static-menu-button" data-route="{{route('front_cart')}}">
    <a><h4>@lang('front/menu.menu-cart') (<span class="total-products">{{$total_products}}</span>)</h4></a>
</li> --}}

</ul>
