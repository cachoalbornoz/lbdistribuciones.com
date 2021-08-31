<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
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
            'proveedor'         => 'required',
            'tipocomprobante'   => 'required',
            'fecha'             => 'required',            
            'nro'               => 'required',
            'total'             => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tipocomprobante.required'  => 'Tipo comprobante es obligatorio',
            'proveedor.required'        => 'Proveedor es obligatorio',
            'fecha.required'            => 'Fecha es obligatorio',
            'nro.required'              => 'Nro Comprobante es obligatorio',
            'total.required'            => 'Importe total es obligatorio'            
        ];
    }
}
