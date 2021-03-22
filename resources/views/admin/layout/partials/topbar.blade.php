<nav class="topbar">
    <div class="topbar-title">
        <h4>@lang('admin/'.$route.'.parent_section')</h4>
    </div>

    @if(in_array('create', $crud_permissions))
        @canatleast(['create'])
            <div class="toggle-table" id="create-button" url="{{route($route .'_create')}}">
                <svg viewBox="0 0 32 32">
                    <circle cx="16" cy="16" r="15"></circle>
                    <g id="plus">
                        <path d="M16,11 L16,21"></path>
                        <path d="M11,16 L21,16"></path>
                    </g>
                </svg>
            </div>
        @endcanatleast
    @endif

    @include('admin.components.messages')
</nav>
