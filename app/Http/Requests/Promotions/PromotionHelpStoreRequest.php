<?php

namespace App\Http\Requests\Promotions;

use Illuminate\Foundation\Http\FormRequest;

class PromotionHelpStoreRequest extends FormRequest
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
        $this->merge([ 'user_id' => (integer) auth()->user()->id ]);
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
            'year'            =>  ['required', 'integer', 'min:'.$this->actualYear],
            'price'           =>  ['required', 'integer', 'min:1'],
            'quantity'        =>  ['required', 'integer', 'min:0'],
            'user_id'         =>  ['required', 'integer', 'min:1', 'exists:users,id'],
            'amount'          =>  ['required', 'integer', 'min:1'],
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
            'amount'          =>  'Monto de recaudación',
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
            'publisher.max'           => ':attribute debe contener un máximo de 255 carácteres',
            'price.min'               => ':attribute debe tener un costo un mínimo de 1$.',
            'quantity.min'            => ':attribute debe ser de valor mínimo 0.',
            'year.max'                => ':attribute no debe ser menor al año en curso (' . $this->actualYear . ').',
            'amount.min'              => ':attribute debe tener un total mínimo de 1$.',
         ];
    }
}
