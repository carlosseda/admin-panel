<nav class="topbar" id="topbar">
    <div class="topbar-left">
        <div class="topbar-title">
            <h4 id="section-title">@lang('admin/'.$route.'.parent_section')</h4>
        </div>
    </div>

    <div class="topbar-center">
        <div class="topbar-menu">
            <ul>
                <li class="menu-item" data-url="{{route('users')}}">Usuarios</li>
                <li class="menu-item" data-url="{{route('customers')}}">Clientes</li>
                <li class="menu-item" data-url="{{route('faqs')}}">Faqs</li>
                <li class="menu-item"  data-url="{{route('faqs_categories')}}">Categorías Faqs</li>
            </ul>
        </div>
    </div>

    <div class="topbar-right">
        <div class="topbar-menu-button">
            <button type="button" id="topbar-collapse-button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>
