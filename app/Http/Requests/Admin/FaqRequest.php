<?php

/*
|--------------------------------------------------------------------------
| Validaciones del formulario de la sección FAQ's
|--------------------------------------------------------------------------
|
| **authorize: determina si el usuario debe estar autorizado para enviar el formulario. 
|
| **rules: recoge las normas que se deben cumplir para validar el formulario. Los errores son 
|   devueltos en forma de objeto JSON en un error 422.
| 
| **messages: mensajes personalizados de error.
|    
*/

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El titulo es obligatorio',
            'description.required' => 'Debe añadir una descripción',
        ];
    }
}
