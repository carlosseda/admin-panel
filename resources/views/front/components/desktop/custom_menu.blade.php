@if(!isset($innerLoop))
<ul class="{{$type == 'horizontal' ? 'menu-inline':''}} {{$type == 'vertical' ? 'menu-vertical':''}}">
@else
<ul class="menu">
@endif

@foreach ($items->sortBy('order') as $item)

    <li>
        @isset($item->locale_seo_id)
            <span class="menu-item {{str_contains(url()->current(), $item->custom_url) && $item->custom_url != null? 'menu-item-selected':''}}" data-route="/{{$item->language}}/{{$item->custom_url}}">
                <h4>{{$item->name}}</h4>
            </span>
        @else
            <a href="{{$item->custom_url}}">
                <h4>{{$item->name}}</h4>
            </a>
        @endisset

        @if(!$item->children->isEmpty())
            @include('front.components.desktop.custom_menu', ['items' => $item->children, 'innerLoop' => true])
        @endif      
    </li>

@endforeach

</ul>
