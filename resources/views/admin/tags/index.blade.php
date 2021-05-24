@php
    $route = 'tags';
    $filters = ['parent' => $groups]; 
    $order = ['grupo' => 'group' , 'clave' => 'key', 'fecha de creación' => 'created_at'];
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($tags)

        <div id="table-container">
            @foreach($tags as $tag_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Grupo:</span> {{$tag_element->group}}</p></div>
                        <div class="table-field"><p><span>Clave:</span> {{$tag_element->key}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('tags_edit', ['group' => str_replace('/', '-' , $tag_element->group) , 'key' => $tag_element->key])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                    </div>
                </div>
            @endforeach
        </div>

        @include('admin.components.table_pagination', ['items' => $tags])
        
    @endisset

@endsection

@section('form')

    @isset($tag->group)

        <div class="form-container">

            <form class="admin-form" id="tags-form" action="{{route("tags_store")}}" autocomplete="off">
            
                {{ csrf_field() }}
        
                <input type="hidden" name="group" value="{{$tag->group}}">
                <input type="hidden" name="key" value="{{$tag->key}}">

                <input autocomplete="false" name="hidden" type="text" style="display:none;">

                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="content">
                                Contenido
                            </li>      
                        </ul>
                    </div>
                    
                    <div class="tabs-container-buttons">       
                        @include('admin.components.form_buttons', ['route' => $route])
                    </div>
                </div>
                
                <div class="tab-panel tab-active" data-tab="content">

                    @if($tag->id)

                        @component('admin.components.locale', ['tab' => 'content'])

                            @foreach ($localizations as $localization)

                                <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                                    <div class="one-column">
                                        <div class="form-group">
                                            <div class="form-label">
                                                <label for="name" class="label-highlight">Traducción para la clave {{$tag->key}} del grupo {{$tag->group}}</label>
                                            </div>
                                            <div class="form-input">
                                                <input type="text" name="tag[value.{{$localization->alias}}]" value="{{isset($tag["value.$localization->alias"]) ? $tag["value.$localization->alias"] : ''}}" class="input-highlight">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            @endforeach
                    
                        @endcomponent
                    
                    @else

                    @endif

                </div>

                
            </form>

        </div>
    
    @else

        <div class="form-container">
            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="content">
                            Contenido
                        </li>      
                    </ul>
                </div>
            </div>

            <div class="tab-panel tab-active" data-tab="content">
                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label>
                            Pulse <span id="import-tags" data-url="{{route('tags_import')}}">aquí</span> para importar todos los archivos de traducciones.
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

@endsection

