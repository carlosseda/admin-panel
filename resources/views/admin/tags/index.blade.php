@php
    $route = 'tags';
@endphp

@extends('admin.layout.table_form')

@section('table')

    <div class="table-container">       
        
        @include('admin.layout.components.table_filters', [
            'subfilter' => $groups,
            'import' => 'tags_import'
        ])

        <table id="main-table" class="mdl-data-table"  route="{{route($route . '_json')}}">
            <thead>
                <tr>
                    <th data-data="id" data-name="id" data-visible="false">#</th>
                    <th data-data="group" data-name="group" id="subfilter-column">Grupo</th>
                    <th data-data="key" data-name="key">Clave</th>
                    <th data-data="updated_at" data-name="updated_at" class="minimize-column">Modificado</th>
                    <th data-orderable="false" data-defaultContent="
                        @include('admin.layout.components.table_buttons')
                        ">
                    </th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@section('form')

    @isset($tags)

        @include('admin.components.errors')

        <form class='admin-form' id='{{$route}}-form' action="{{route($route.'_store')}}">
        
            {{ csrf_field() }}
    
            @isset ($tags->id)
                <input type="hidden" name="group" value="{{$tags->group}}">
                <input type="hidden" name="key" value="{{$tags->key}}">
            @endisset

            <input class="input-id" type="hidden" name="id" value="{{isset($tags->id) ? $tags->id : '' }}">

            <div class="nav-tabs-container">
                <div class="nav-tabs-container-menu">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item active">
                            <a href="#contenido" class="nav-link active" aria-controls="contenido" role="tab" data-toggle="tab" aria-expanded="true">
                                <span>Contenido</span>
                            </a>
                        </li>       
                    </ul>
                </div>
    
                <div class="nav-tabs-container-buttons">
                    <div class="crud-buttons-container">
                        <button class="crud-buttons" id="store-button" class="btn btn-main"> 
                            <svg viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none"/>
                                <path class="store-button-icon" d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                            </svg>
                        </button>
                    </div>
                </div>   
            </div>
    
            <div class="tab-content">
    
                <div role="tabpanel" class="tab-pane active" id="contenido">

                    <div class="form-content">
                        
                        @component('admin.components.locale')
        
                        @foreach ($localizations as $localization)
                
                        <div role="tabpanel" class="tab-pane {{ $loop->first ? ' active' : '' }}" id="{{$localization->alias}}">
                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label for="locale" class="locale-value-{{$localization->alias}}">
                                                Valor *
                                            </label>
                                        </div>
                                        <div class="input-container">
                                            <input type="text" name="locale[value.{{$localization->alias}}]" value='{{$locale["value.$localization->alias"]}}' class="form-control locale-value-{{$localization->alias}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        @endforeach
                
                        @endcomponent
                    </div>

                </div>

            </div>

        </form>

    @endisset

@endsection

