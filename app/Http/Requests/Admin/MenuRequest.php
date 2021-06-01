<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','min:3', 'max:255', Rule::unique('t_menu')->ignore($this->id)]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El mínimo de caracteres permitidos para el nombre son 3',
            'name.max' => 'El máximo de caracteres permitidos para el nombre son 255',
            'name.unique' => 'El nombre ya existe',
        ];
    }
}
