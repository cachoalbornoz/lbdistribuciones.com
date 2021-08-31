<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
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
            'proveedor'         => 'required',
            'tipocomprobante'   => 'required',
            'nro'               => 'required',
            'fecha'             => 'required',
            'formapago'         => 'required',
            'observaciones'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'proveedor.required'        => 'Proveedor es obligatorio',
            'tipocomprobante.required'  => 'Tipo comprobante es obligatorio',
            'nro.required'              => 'Nro Comprobante es obligatorio',
            'fecha.required'            => 'Fecha es obligatorio',
            'formapago.required'        => 'Forma pago es obligatorio',
            'observaciones.required'    => 'Observaciones son obligatorias cargarlas',
        ];
    }
}