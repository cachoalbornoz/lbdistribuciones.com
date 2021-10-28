<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoRequest extends FormRequest
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
            'contacto'          => 'required',
            'fecha'             => 'required',
            'vendedor'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contacto.required'         => 'Cliente es obligatorio',
            'fecha.required'            => 'Fecha es obligatorio',
            'vendedor.required'         => 'Vendedor es obligatorio',
        ];
    }
}