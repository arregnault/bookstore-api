<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    private $actualYear = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    
    protected function prepareForValidation()
    {
        $this->actualYear = date("Y");
    }


    /**'
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'           =>  ['required', 'string'],
            'isbn'            =>  ['required', 'string', 'min:10', 'max:13'],
            'publisher'       =>  ['required', 'string', 'min:3', 'max:50'],
            'year'            =>  ['required', 'integer', 'min:1000', 'max:'.$this->actualYear],
            'price'           =>  ['required', 'integer', 'min:1'],
            'quantity'        =>  ['required', 'integer', 'min:0'],
            'user_id'         =>  ['required', 'integer', 'min:1', 'exists:users,id'],
        ];
    }

    public function attributes()
    {
        return [
            'title'           =>  'Título',
            'isbn'            =>  'ISBN',
            'publisher'       =>  'Editor',
            'year'            =>  'Año',
            'price'           =>  'Precio',
            'quantity'        =>  'Cantidad',
            'user_id'         =>  'Autor',
        ];
    }

    public function messages()
    {
        return [
            'required'                => ':attribute es un campo requerido.',
            'integer'                 => ':attribute debe ser un número entero.',
            'numeric'                 => ':attribute debe ser un número válido.',
            'string'                  => ':attribute debe ser una cadena de carácteres válida.',
            'user_id.min'             => ':attribute no existe.',
            'exists'                  => ':attribute no existe.',
            'isbn.min'                => ':attribute debe contener un mínimo de 10 carácteres.',
            'isbn.max'                => ':attribute debe contener un máximo de 13 carácteres',
            'publisher.min'           => ':attribute debe contener un mínimo de 3 carácteres.',
            'publisher.max'           => ':attribute debe contener un máximo de 50 carácteres',
            'price.min'               => ':attribute debe tener un costo un mínimo de 1$.',
            'quantity.min'            => ':attribute debe ser de valor mínimo 0.',
            'year.min'                => ':attribute no debe ser menor a 1000.',
            'year.max'                => ':attribute no debe ser mayor al año en curso (' . $this->actualYear . ').',
         ];
    }
}
