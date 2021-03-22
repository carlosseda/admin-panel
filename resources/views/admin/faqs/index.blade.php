@php
    $route = 'faqs';
@endphp

@extends('admin.layout.table_form')

@section('table')

    @include('admin.components.modal_delete')

    <div class="table-container">         

        <table id="main-table" class="mdl-data-table"  route="{{route($route . '_json')}}">
            <thead>
                <tr>                        
                    <th data-data="id" data-name="id" data-visible="false">Id</th>
                    <th data-data="title" data-name="title">Nombre</th>
                    <th data-data="description" data-name="description" id="subfilter-column">Categoría</th>
                    <th data-data="updated_at" data-name="updated_at" class="minimize-column">Modificado</th>
                    <th data-defaultContent="
                    @include('admin.layout.components.table_buttons', ['route' => $route])
                        ">
                    </th>
                </tr>
            </thead>
        </table>
    </div>

@endsection

@section('form')

    @isset($faq)

    <div class="form">	
        <div class="form-error" >
            <p id="error-message"></p>
        </div>
    
        <div class="form-container">
            <form class='admin-form' id='{{$route}}-form' action="{{route($route.'_store')}}"id="faqs-form" action="{{route("faqs_store")}}" autocomplete="off">
                
                {{ csrf_field() }}
    
                <input autocomplete="false" name="hidden" type="text" style="display:none;">
    
                <div class="form-group">
                    <div class="form-label">
                        <label for="title" class="label">Título</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="title" value="" class="input" id="faqs-title" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">
                        <label for="description">Descripción</label>
                    </div>
                    <div class="form-input">
                        <textarea name="description" value="" class="input"></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="form-footer">        
            <div class="form-submit">
                <button id="send-button">Enviar</button>
            </div>
        </div>
    </div>
        <form class='admin-form' id='{{$route}}-form' action="{{route($route.'_store')}}">

            {{ csrf_field() }}

            <input class="input-id" type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : '' }}">

            <div class="nav-tabs-container">
                <div class="nav-tabs-container-menu">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item">
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
    
                    <div class="switch-container">
                        <div class="onoffswitch">
                            <input type="checkbox" name="active" value="{{$faq->active == 1 ? 'true' : 'false'}}" {{ old('_token') ? old('activo') : $faq->active == 1 ? 'checked' : '' }} class="onoffswitch-checkbox" id="myonoffswitch">
                            <label class="onoffswitch-label" for="myonoffswitch">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>   
            </div>

            <div class="tab-content">

                <div role="tabpanel" class="tab-panel active" id="contenido">

                    <div class="form-content">

                        @include('admin.components.errors')

                        <div class="two-columns">
                            <div class="form-group">
                                <div class="label-container">
                                    <label for="name" class="name">
                                        Nombre *
                                    </label>
                                </div>
                                <div class="input-container">
                                    <input type="text" name="name" value="{{ old('_token') ? old('name') : $faq->name }}" class="form-control name">
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <div class="label-container">
                                    <label for="category_id" class="category_id">
                                        Categoría *
                                    </label>
                                </div>
                                <div class="input-container">
                                    <select name="category_id" data-placeholder="Seleccione una categoría" class="form-control category_id">
                                        <option></option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$faq->category_id == $category->id ? 'selected':''}} class="category_id">{{ $category->name }}</option>
                                        @endforeach
                                    </select>                   
                                </div>
                            </div>
                        </div>

                        @component('admin.components.locale')

                        @foreach ($localizations as $localization)
                    
                        <div role="tabpanel" class="tab-pane {{ $loop->first ? ' active' : '' }}" id="{{$localization->alias}}">
                            <div class="one-column">
                                <div class="form-group">
                                    <div class="label-container">
                                        <label for="titulo" class="locale-title-{{$localization->alias}}">
                                            Título *
                                        </label>
                                    </div>
                                    <div class="input-container">
                                        <input type="text" name="locale[title.{{$localization->alias}}]" value="{{isset($locale["title.$localization->alias"]) ? $locale["title.$localization->alias"] : ''}}" class="form-control locale-title-{{$localization->alias}}">
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="label-container">
                                        <label for="description"  class="locale-description-{{$localization->alias}}">
                                            Descripción *
                                        </label>
                                    </div>
                                    <div class="input-container">
                                        <textarea name="locale[description.{{$localization->alias}}]" class="rich basic" id="ckeditor.{{$localization->alias}}" class="form-control locale-description-{{$localization->alias}}">{{isset($locale["description.$localization->alias"]) ? $locale["description.$localization->alias"] : ''}}</textarea>
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





    


