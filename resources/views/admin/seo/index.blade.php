{{--      
    Las filas marcadas en rojo son las que vienen con descripcion o keywords vacías, dicha función se define en el archivo easydevel-datatable.js

    if (data['description.description'] == null || data['keywords.keywords'] == null) {
        $(row).addClass('highlight');
    }

--}}

@php
    $route = 'seo';
@endphp

@extends('admin.layout.table_form')

@section('table')

    <div class="table-container">       
        
        @include('admin.layout.components.table_filters', [
            'import' => 'seo_import',
            'ping' => 'seo_ping_google',
        ])

        <table id="main-table" class="mdl-data-table"  route="{{route($route . '_json')}}">
            <thead>
                <tr>
                    <th data-data="id" data-name="id" data-visible="false"></th>
                    <th data-data="title" data-name="title">Titulo</th>
                    <th data-data="description" data-name="description" class="minimize-column">Descripcion</th>
                    <th data-data="keywords" data-name="keywords" class="minimize-column">Keywords</th>
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

    @isset($seo)

        @include('admin.components.errors')

        <form class='admin-form' id='{{$route}}-form' action="{{route($route.'_store')}}">
        
            {{ csrf_field() }}

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
                        <button class="crud-buttons" data-route="{{route('seo_ping_google')}}" id="store-button" class="btn btn-main"> 
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

                        <input type="hidden" name="seo[old_url.{{$localization->alias}}]" value="{{isset($seo["url.$localization->alias"]) ? $seo["url.$localization->alias"] : ''}}">
                        <input class="input-id" type="hidden" name="id" value="{{isset($seo->id) ? $seo->id : '' }}">

                        @isset ($seo["group.$localization->alias"])
                            <input type="hidden" name="seo[group.{{$localization->alias}}]" value="{{$seo["group.$localization->alias"]}}">
                            <input type="hidden" name="seo[key.{{$localization->alias}}]" value="{{$seo["key.$localization->alias"]}}">
                        @endisset

                        <div role="tabpanel" class="tab-pane {{ $loop->first ? ' active' : '' }}" id="{{$localization->alias}}">
                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label for="locale" class="seo-url-{{$localization->alias}}">
                                                Url *
                                            </label>
                                        </div>
                                        <div class="input-container">
                                            <input type="text" name="seo[url.{{$localization->alias}}]" value='{{isset($seo["url.$localization->alias"]) ? $seo["url.$localization->alias"] : '' }}' class="form-control block-parameters seo-url-{{$localization->alias}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label for="locale" class="seo-title-{{$localization->alias}}">
                                                Título
                                            </label>
                                        </div>
                                        <div class="input-container">
                                            <input type="text" name="seo[title.{{$localization->alias}}]" value='{{isset($seo["title.$localization->alias"]) ? $seo["title.$localization->alias"] : '' }}' class="form-control seo-title-{{$localization->alias}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label for="locale" class="seo-description-{{$localization->alias}}">
                                                Descripcion
                                            </label>
                                        </div>
                                        <div class="input-container">
                                            <input type="text" name="seo[description.{{$localization->alias}}]" value='{{isset($seo["description.$localization->alias"]) ? $seo["description.$localization->alias"] : '' }}' class="form-control seo-description-{{$localization->alias}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label for="locale" class="seo-keywords-{{$localization->alias}}">
                                                Keywords
                                            </label>
                                        </div>
                                        <div class="input-container">
                                            <input type="text" name="seo[keywords.{{$localization->alias}}]" value='{{isset($seo["keywords.$localization->alias"]) ? $seo["keywords.$localization->alias"] : ''}}' class="form-control seo-keywords-{{$localization->alias}}">
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
