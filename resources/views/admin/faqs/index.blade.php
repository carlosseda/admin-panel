@extends('admin.layout.table_form')

@section('table')

    <table>
        <tr>
            <th>Id</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>
               
            </th>
        </tr>

        @foreach($faqs as $faq_element)
            <tr>
                <td>{{$faq_element->id}}</td>
                <td>{{$faq_element->name}}</td>
                <td>{{$faq_element->category->name}}</td>
                <td class="table-icons-container">
                    <div class="table-icons edit-button" data-url="{{route('faqs_edit', ['faq' => $faq_element->id])}}">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                        </svg>
                    </div> 
                   
                    <div class="table-icons delete-button" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}">
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

    @include('admin.components.errors')

    <div class="form-container">
        <form class="admin-form" id="faqs-form" action="{{route("faqs_store")}}" autocomplete="off">
            
            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : ''}}">

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
                    <label for="title" class="label-highlight">Nombre</label>
                </div>
                <div class="form-input">
                    <input type="text" name="name" value="{{isset($faq->name) ? $faq->name : ''}}"  class="input-highlight"  />
                </div>
            </div>
            
            <div class="form-group">
                <div class="form-label">
                    <label for="description" class="label-highlight">Descripción</label>
                </div>
                <div class="form-input">
                    <textarea class="ckeditor" name="description" class="input-highlight">{{isset($faq->description) ? $faq->description : ''}}</textarea>
                </div>
            </div>
        </form>
    </div>
    
    <div class="form-footer">        
        <div class="form-submit">
            <button id="send-button">Enviar</button>
        </div>
    </div>

@endsection






    


