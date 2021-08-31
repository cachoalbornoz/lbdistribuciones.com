<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CobroRequest extends FormRequest
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'tipocomprobante'   => 'required',
            'contacto'          => 'required',
            'fecha'             => 'required',
            'nro'               => 'required',
            'observaciones'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tipocomprobante.required'  => 'Tipo comprobante es obligatorio',
            'contacto.required'         => 'Cliente es obligatorio',
            'fecha.required'            => 'Fecha es obligatorio',
            'nro.required'              => 'Nro Comprobante es obligatorio',
            'observaciones.required'    => 'Observaciones son obligatorias cargarlas',
        ];
    }
}
