<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookDiscountRequest extends FormRequest
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
            'discount'          => ['required','integer', 'min:0', 'max:100'],
            'discount_ends_at'  => ['required','date', 'after_or_equal:' . now()->format('Y-m-d')],
            'id'                =>  [
                                        'required',
                                        'integer',
                                        'min:1',
                                        Rule::exists('books', 'id')->where(function ($query) {
                                            return $query->where('user_id', $this->user_id);
                                        })
            ],
            'user_id'           =>  [
                                        'required',
                                        'integer',
                                        'min:1',
                                        Rule::exists('users', 'id')->where(function ($query) {
                                            return $query;
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
            'user_id.exists'          => ':attribute no existe.',
            'id.exists'               => ':attribute no existe o usted no es el autor (por tanto, no tiene permitido gestionarlo).',
            'discount.min'            => ':attribute debe ser de mínimo 0%.',
            'discount_ends_at.max'    => ':attribute no puede ser mayor al 100%.',
            'date'                    => ':attribute debe ser una fecha válida (d-m-Y).',
            'after_or_equal'          => ':attribute debe ser igual o mayor a la fecha de hoy.',
        ];
    }
}
