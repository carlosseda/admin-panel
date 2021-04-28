@php
    $route = 'faqs';
    $filters = ['category' => $faqs_categories, 'search' => true, 'created_at' => true ]; 
    $order = ['fecha de creación' => 'created_at', 'nombre' => 'name', 'categoría' => 'category_id'];
@endphp

@extends('admin.layout.table_form')

@section('table')
    
    @isset($faqs)

        <div id="table-container">
            @foreach($faqs as $faq_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Nombre:</span> {{$faq_element->name}}</p></div>
                        <div class="table-field"><p><span>Categoría:</span> {{$faq_element->category->name}}</p></div>
                        <div class="table-field"><p><span>Creado el:</span> {{ Carbon\Carbon::parse($faq_element->created_at)->format('d-m-Y') }}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('faqs_edit', ['faq' => $faq_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @include('admin.components.table_pagination', ['items' => $faqs])
        
    @endif

@endsection

@section('form')

    @isset($faq)

        <div class="form-container">
            <form class="admin-form" id="faqs-form" action="{{route("faqs_store")}}" autocomplete="off">
                
                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : ''}}">

                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="contenido">
                                Contenido
                            </li>      
                        </ul>
                    </div>
                    
                    <div class="tabs-container-buttons">
                        
                        @include('admin.components.form_buttons', ['route' => $route])
                        
                    </div>
                </div>
                
                <div class="tab-panel tab-active" data-tab="contenido">
                    <div class="two-columns">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="category_id" class="label-highlight">
                                    Categoría 
                                </label>
                            </div>
                            <div class="form-input">
                                <select name="category_id" data-placeholder="Seleccione una categoría" class="input-highlight">
                                    <option></option>
                                    @foreach($faqs_categories as $faq_category)
                                        <option value="{{$faq_category->id}}" {{$faq->category_id == $faq_category->id ? 'selected':''}} class="category_id">{{ $faq_category->name }}</option>
                                    @endforeach
                                </select>                   
                            </div>
                        </div>
            
                        <div class="form-group">
                            <div class="form-label">
                                <label for="name" class="label-highlight">Nombre</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{isset($faq->name) ? $faq->name : ''}}"  class="input-highlight"  />
                            </div>
                        </div>
                    </div>
                    
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="description" class="label-highlight">Descripción</label>
                            </div>
                            <div class="form-input">
                                <textarea class="ckeditor" name="description" class="input-highlight">{{isset($faq->description) ? $faq->description : ''}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif  

@endsection


