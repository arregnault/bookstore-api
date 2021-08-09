<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookReservationRequest extends FormRequest
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
        
    protected function prepareForValidation()
    {
        $id = $this->route('id');
        $this->merge([ 'id'        => (integer) $id ]);
        $this->merge([ 'user_id' => (integer) auth()->user()->id ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'              =>  [
                                    'required',
                                    'integer',
                                    'min:1',
                                    Rule::exists('books', 'id')->where(function ($query) {
                                        return $query->where('quantity', '>', 0);
                                    })
            ],
            'user_id'         =>  [
                                    'required',
                                    'integer',
                                    'min:1',
                                    Rule::exists('users', 'id')->where(function ($query) {
                                        return $query->where('account_balance', '>', 0);
                                    })
            ],
        ];
    }

    public function attributes()
    {
        return [
            'id'         => 'Libro',
            'user_id'    => 'Usted',
        ];
    }

    public function messages()
    {
        return [
            'required'                => ':attribute es un campo requerido.',
            'integer'                 => ':attribute debe ser un número entero.',
            'numeric'                 => ':attribute debe ser un número válido.',
            'id.min'                  => ':attribute no existe.',
            'user_id.min'             => ':attribute no existe.',
            'user_id.exists'          => ':attribute no cuenta con balance/saldo positivo.',
            'id.exists'               => ':attribute no existe o no cuenta con suficientes existencias.',
        ];
    }
}
