@if(isset($tab))

    <div class="locale-tabs-container">
        <div class="locale-tabs-container-menu">
            <ul>
                @foreach ($localizations as $localization)
                    <li class="locale-tab-item {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="{{$tab}}" data-localetab="{{$localization->alias}}">
                        {{$localization->name}}
                    </li>      
                @endforeach
            </ul>
        </div>
    </div>


    {{ $slot }}

@endif