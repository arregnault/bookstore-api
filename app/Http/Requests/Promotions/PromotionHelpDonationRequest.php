<?php

namespace App\Http\Requests\Promotions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromotionHelpDonationRequest extends FormRequest
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


    /**'
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
                                    Rule::exists('promotion_helps', 'id')->where(function ($query) {
                                        return $query;
                                    })
            ],

            'user_id'         =>  ['required', 'integer', 'min:1', 'exists:users,id'],
            'amount'          =>  ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'id'              =>  'Promoción',
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
            'id.min'                   => ':attribute no existe.',
            'exists'                  => ':attribute no existe.',
            'amount.min'              => ':attribute debe tener un total mínimo de 1$.',
         ];
    }
}
