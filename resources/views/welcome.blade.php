@extends('admin.layout.master')

@section('content')

<div class="form">	
    <div class="form-error" >
        <p id="error-message"></p>
    </div>

    <div class="form-container">
        <form id="faqs-form" action="{{route("faqs_store")}}" autocomplete="off">
            
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

@endsection
