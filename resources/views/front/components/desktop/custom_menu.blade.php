@if(!isset($innerLoop))
<ul class="{{$type == 'horizontal' ? 'menu-inline':''}} {{$type == 'vertical' ? 'menu-vertical':''}}">
@else
<ul class="menu">
@endif

@foreach ($items->sortBy('order') as $item)

    <li class="deeper parent">

        <a href="{{$item->custom_url}}">
            <h4>{{$item->name}}</h4>
        </a>

        @if(!$item->children->isEmpty())
            @include('front.components.desktop.custom_menu', ['items' => $item->children, 'innerLoop' => true])
        @endif
        
    </li>

@endforeach

</ul>
