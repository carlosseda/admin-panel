@php
    $route = 'menus_item';
@endphp

@isset($menu->name)

    <div id="menu-item-modal-container">
        @include('admin.components.modal_menu_item', ['menu' => $menu])
    </div>

    @component('admin.components.locale', ['tab' => 'content'])

        @foreach ($localizations as $localization)

            <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">
                    
                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label>
                                Pulse <span class="menu-item-create" data-url="{{route('menus_item_create')}}" data-menu="{{$menu->id}}" data-language="{{$localization->alias}}">aquí</span> para añadir un nuevo elemento al menu.
                            </label>
                        </div>
                    </div>
                </div>

                @isset($menu->parent_items)
                    <div class="one-column">
                        <div class="form-group">
                            @include('admin.components.items_nestables', [
                                'language' => $localization->alias,
                                'route' => 'menus_item_index', 
                                'order_route' => 'menus_reorder',
                                'edit_route' => 'menus_item_edit',
                                'delete_route' => 'menus_item_destroy',
                                'edit_class' => 'menu-item-edit',
                                'delete_class' => 'menu-item-delete'
                            ])
                        </div>
                    </div>
                @endisset
                
            </div>

        @endforeach

    @endcomponent
            
@endisset