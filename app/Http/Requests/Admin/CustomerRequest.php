<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'surname' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'address' => 'required',
            'postcode' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'surname.required' => 'Los apellidos son obligatorios',
            'telephone.required' => 'El teléfono es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato de email es incorrecto',
            'city.required' => 'La ciudad es obligatoria',
            'address.required' => 'La dirección es obligatoria',
            'postcode.required' => 'El código postal es obligatorio',
        ];
    }
}
