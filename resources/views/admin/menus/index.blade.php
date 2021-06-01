@php
    $route = 'menus';
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($menus)

        <div id="table-container">
            @foreach($menus as $menu_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Nombre:</span> {{$menu_element->name}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('menus_edit', ['menu' => $menu_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('menus_destroy', ['menu' => $menu_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @include('admin.components.table_pagination', ['items' => $menus])

    @endisset

@endsection

@section('form')

    @isset($menu)

        <div class="form-container">
            <form class="admin-form" id="menus-form" action="{{route("menus_store")}}" autocomplete="off">
                
                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($menu->id) ? $menu->id : ''}}">

                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="content">
                                Contenido
                            </li>      
                        </ul>
                    </div>
                    
                    <div class="tabs-container-buttons">
                        
                        @include('admin.components.form_buttons', ['route' => $route, 'create' => 'create'])
                        
                    </div>
                </div>
                
                <div class="tab-panel tab-active" data-tab="content">
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="name" class="label-highlight">Nombre</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{isset($menu->name) ? $menu->name : ''}}"  class="input-highlight"  />
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <div id="menu-item-form-container">
                @include('admin.menu_items.index', ['menu' => $menu])
            </div>

        </div>

    @endisset

@endsection