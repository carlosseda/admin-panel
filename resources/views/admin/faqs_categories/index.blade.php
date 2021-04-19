@php
    $route = 'faqs_categories';
@endphp

@extends('admin.layout.table_form')

@section('table')

    <table>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th></th>
        </tr>

        @foreach($faqs_categories as $faq_category_element)
            <tr>
                <td>{{$faq_category_element->id}}</td>
                <td>{{$faq_category_element->name}}</td>
                <td class="table-icons-container">
                    <div class="table-icons edit-button" data-url="{{route('faqs_categories_edit', ['faq_category' => $faq_category_element->id])}}">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                        </svg>
                    </div> 
                   
                    <div class="table-icons delete-button" data-url="{{route('faqs_categories_destroy', ['faq_category' => $faq_category_element->id])}}">
                        <svg class="table-icons" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                        </svg>
                    </div>
                </td>
            </tr>
        @endforeach
        
    </table>

@endsection

@section('form')

    <div class="form-container">
        <form class="admin-form" id="faqs-form" action="{{route("faqs_categories_store")}}" autocomplete="off">
            
            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($faq_category->id) ? $faq_category->id : ''}}">
            
            <div class="tabs-container-menu">
                <ul>
                    <li class="tab-item tab-active" data-tab="contenido">
                        Contenido
                    </li> 
                </ul>
            </div>

            <div class="tab-panel tab-active" data-tab="contenido">
                <div class="form-group">
                    <div class="form-label">
                        <label for="name" class="label-highlight">Nombre</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="name" value="{{isset($faq_category->name) ? $faq_category->name : ''}}" class="input-highlight"  />
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="form-footer">        
        <div class="form-submit">
            <button id="send-button">Guardar</button>
        </div>
    </div>

@endsection






    


