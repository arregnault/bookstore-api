<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'email'    => 'Correo electrónico',
            'password' => 'Contraseña',
        ];
    }

    public function messages()
    {
        return [
            'required'     => ':attribute es un campo requerido.',
            'email'        => ':attribute debe ser un correo electrónico válido.',
            'string'       => ':attribute debe ser una cadena de carácteres válida',
        ];
    }
}
