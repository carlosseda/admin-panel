<div id="menu-item-modal" class="modal">

    <form id="menu-item-form" action="{{route('menus_item_store')}}">

        {{ csrf_field() }}

        <input type="hidden" name="menu_id" value="{{isset($menu->id) ? $menu->id : ''}}" id="menu-id">
        <input type="hidden" name="id" value="{{isset($menu_item->id) ? $menu_item->id : ''}}">
        <input type="hidden" name="language" value="{{isset($menu_item->language) ? $menu_item->language : ''}}" id="menu-item-language">

        <div class="one-column">
            <div class="form-group">
                <div class="form-label">
                    <label for="titulo" class="name">
                        Título del enlace
                    </label>
                </div>
                <div class="form-input">
                    <input type="text" name="name" value='@isset($menu_item){{$menu_item->name ? $menu_item->name : ''}}@endisset' class="form-control name">
                </div>
            </div>
        </div>

        <div class="one-column">
            <div class="form-group">
                <div class="form-label">
                    <label for="tipo">
                        Tipo de enlace
                    </label>
                </div>
                <div class="form-input">
                    <select id="menu-item-parent" class="form-control select-display">
                        <option disabled selected value style="display:none"></option>
                        <option id="custom_url" value="custom_url" @isset($menu_item){{$menu_item->custom_url != null ? 'selected':''}} @endisset>Personalizado</option>
                        <option id="section" value="section" @isset($menu_item){{$menu_item->locale_seo_id != null ? 'selected':''}} @endisset>Enlace a página</option>
                    </select>                   
                </div>
            </div>
        </div>

        <div class="one-column">
            <div class="form-group">
                <div class="select-display-option @isset($menu_item) {{ $menu_item->custom_url != null ? 'visible':''}} @endisset" data-option="custom_url">
                    <div class="form-label">
                        <label for="url" class="custom_url">
                            Url
                        </label>
                    </div>
                    <div class="form-input">
                        <input value="@isset($menu_item){{$menu_item->locale_seo_id == null ? $menu_item->custom_url : ''}} @endisset" type="text" name="custom_url" class="form-control custom_url">
                    </div>
                </div>

                <div class="select-display-option  @isset($menu_item) {{ $menu_item->locale_seo_id != null ? 'visible':''}} @endisset" data-option="section">
                    <div class="form-label">
                        <label for="tipo" class="locale_seo_id">
                            Sección
                        </label>
                    </div>
                    <div class="form-input">
                        <select id="menu-section" name="locale_seo_id" class="form-control primary-select-related">
                            <option disabled selected value style="display:none"></option>
                            @foreach($sections as $section)
                                <option id="menu-section-option" value="{{$section->id}}" @isset($menu_item){{$menu_item->locale_seo_id == $section->id ? 'selected':''}} @endisset>{{$section->title}}</option>
                            @endforeach
                        </select>                   
                    </div>
                </div>
            </div>
        </div>

        <div class="one-column">
            <div class="form-group">
                <div class="select-related @isset($menu_item){{ $menu_item->locale_slug_seo_id != null ? 'visible':''}} @endisset">
                    <div class="form-label">
                        <label for="tipo" class="locale_slug_seo_id">
                            Enlaces
                        </label>
                    </div>
                    <div class="form-input">
                        <select id="menu-links" name="locale_slug_seo_id"  class="form-control secondary-select-related">
                            <option disabled selected value style="display:none"></option>
                            @foreach($links as $link)
                                @if(!empty($link->locale_seo->language))
                                    <option class="menu-section hidden" value="{{$link->id}}" data-related="{{$link->locale_seo->id}}"  @isset($menu_item){{$menu_item->locale_slug_seo_id == $link->id ? 'selected':''}} @endisset>{{$link->title}}</option>
                                @endif
                            @endforeach
                        </select>                   
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="form-button modal-menu-item-store-button" id="modal-menu-item-store-button"> 
        <svg viewBox="0 0 24 24">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path class="store-button-icon" d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
        </svg>
    </div>

</div>