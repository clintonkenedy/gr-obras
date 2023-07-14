<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObraRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cui' => 'required',
            'meta' => 'required',
            'nombre_proyecto' => 'required',
            'sector' => 'required',
            'estado_obra' => 'required',
            'dura_dias' => 'required',
            'fec_ini' => 'required',
            'fec_fin' => 'required',
            // 'archivo_resolucion' => 'required',
            // 'archivo_kmz' => 'required',
            'ubigeo_id' => 'required',
            'coordinador_id' => 'required',
            'residente_id' => 'required',
            'economista_id' => 'required',
        ];
    }
}
