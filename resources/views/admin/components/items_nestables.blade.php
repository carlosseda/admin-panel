@if($language)
    <div class="nested-sort-wrap" id="nested-sort-wrap-{{$language}}" data-order="{{route($order_route)}}" data-route="{{route($route, ['language' => $language])}}"></div>
@else
    <div class="nested-sort-wrap" id="nested-sort-wrap" data-route="{{route($route)}}"></div>
@endif

<div class="item-actions clone" id="item-actions">
    <div class="item-button item-delete {{$delete_class}}" data-route="{{route($delete_route)}}">
        <svg viewBox='0 0 24 24'>
            <path fill='none' d='M0 0h24v24H0V0z'/>
            <path class='button-icon' d='M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z'/>
            <path fill='none' d='M0 0h24v24H0z'/>
        </svg>
    </div>
    <div class="item-button item-edit {{$edit_class}}" data-route="{{route($edit_route)}}">
        <svg viewBox='0 0 24 24'>
            <path class='button-icon' d='M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z'/>
            <path d='M0 0h24v24H0z' fill='none'/>
        </svg>
    </div>
</div>