<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombre'        => 'required',
            'rubro'         => 'required',
            'marca'         => 'required',
            'preciolista'   => 'required',
            'stockaviso'    => 'required',
            'stockactual'   => 'required',
            'image'         => 'mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required'       => 'Nombre producto es obligatorio',
            'marca.required'        => 'Marca es obligatoria',
            'rubro.required'        => 'Rubro es obligatorio',
            'preciolista.required'  => 'Precio lista es obligatorio',
            'stockaviso.required'   => 'Stock aviso es obligatorio',
            'stockactual.required'  => 'Stock actual es obligatorio',
            'image'                 => 'La imagen del producto no tiene formato correcto jpeg | png | jpg ',
            'image.mimes'           => 'La imagen del producto no es jpeg, png, jpg',
            'image.max'             => 'La imagen del producto es demasiada grande',
        ];
    }
}