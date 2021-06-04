@if(!isset($innerLoop))
<ul class="menu-inline">
@else
<ul>
@endif

@foreach ($items->sortBy('order') as $item)

    @if(isset($item->url) || isset($item->custom_url))

            @if(isset($item->url))
            <li class="deeper parent {{strpos(Request::url(), route($item->url)) !== false ? 'selected' : ''}}">

                <a href="{{route($item->url)}}">
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
                @include('front.components.mobile.custom_menu', ['items' => $item->children, 'innerLoop' => true])
            @endif
            
        </li>
    @endif

@endforeach

{{-- <li class="deeper parent cart-button">
    <a href="{{route('front_cart')}}"><h4>@lang('front/menu.menu-cart') (<span class="total-products">{{$total_products}}</span>)</h4></a>
</li> --}}

</ul>
