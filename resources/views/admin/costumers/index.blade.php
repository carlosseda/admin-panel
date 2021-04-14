@php
    $route = 'costumers';
@endphp

@extends('admin.layout.table_form')

@section('table')

    <table>
        <tr>
            <th>Id</th>
            <th>Email</th>
            <th></th>
        </tr>

        @foreach($costumers as $costumer_element)
            <tr>
                <td>{{$costumer_element->id}}</td>
                <td>{{$costumer_element->email}}</td>
                <td class="table-icons-container">
                    <div class="table-icons edit-button" data-url="{{route('costumers_edit', ['costumer' => $costumer_element->id])}}">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                        </svg>
                    </div> 
                   
                    <div class="table-icons delete-button" data-url="{{route('costumers_destroy', ['costumer' => $costumer_element->id])}}">
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
        <form class="admin-form" id="costumers-form" action="{{route("costumers_store")}}" autocomplete="off">
            
            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($costumer->id) ? $costumer->id : ''}}">

            <div class="two-columns">
                <div class="form-group">
                    <div class="form-label">
                        <label for="name" class="label-highlight">Nombre</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="name" value="{{isset($costumer->name) ? $costumer->name : ''}}" class="input-highlight"  />
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="surname" class="label-highlight">Apellidos</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="surname" value="{{isset($costumer->surname) ? $costumer->surname : ''}}" class="input-highlight"  />
                    </div>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <div class="form-label">
                        <label for="telephone" class="label-highlight">Teléfono</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="telephone" value="{{isset($costumer->telephone) ? $costumer->telephone : ''}}" class="input-highlight"  />
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="email" class="label-highlight">Email</label>
                    </div>
                    <div class="form-input">
                        <input type="email" name="email" value="{{isset($costumer->email) ? $costumer->email : ''}}" class="input-highlight"  />
                    </div>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <div class="form-label">
                        <label for="country_id" class="label-highlight">País</label>
                    </div>
                    <div class="form-input">
                        <select name="country_id" class="input-highlight">
                            <option></option>
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}" {{$costumer->country_id == $country->id ? "selected" : ""}}>{{$country->name}}</option>
                            @endforeach
                        </select>       
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="city" class="label-highlight">Ciudad</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="city" value="{{isset($costumer->city) ? $costumer->city : ''}}" class="input-highlight" />
                    </div>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <div class="form-label">
                        <label for="postcode" class="label-highlight">Código Postal</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="postcode" value="{{isset($costumer->postcode) ? $costumer->postcode : ''}}" class="input-highlight" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="address" class="label-highlight">Dirección</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="address" value="{{isset($costumer->address) ? $costumer->address : ''}}" class="input-highlight" />
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






    


