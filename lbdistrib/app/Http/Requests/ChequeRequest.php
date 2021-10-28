<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRequest extends FormRequest
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
            
            'fechacobro'    => 'required',
            'nrocheque'     => 'required',
            'importe'       => 'required',
            'banco'         => 'required',
        ];
    }

    public function messages()
    {
        return [
            'banco.required'  => 'Indique el Banco del nuevo cheque',          
        ];
    }
}