<?php

namespace App\Http\Requests\Persona;

use Illuminate\Foundation\Http\FormRequest;

class PersonaStoreRequest extends FormRequest
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
            'tipo_doc' => 'required',
            'num_doc' => ['required', 'string', 'max:11', 'unique:personas,num_doc'],
            'nombres' => 'required|string|max:191',
            'a_paterno' => 'required|string|max:191',
            'a_materno' => 'required|string|max:191',
            'nombre_completo' => 'required|string|max:573',
            'email' => 'nullable|string|email',
            'direccion' => 'nullable|string|max:191',
            'celular' => 'size:9|nullable',
        ];
    }
}
