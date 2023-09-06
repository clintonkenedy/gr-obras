<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministrativoRequest extends FormRequest
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
            'tipo' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => ($this->id) ? 'min:8' : 'required|min:8',
            'persona_id' => 'required',
            'profesion' => 'required',
            'condicion' => 'required'
        ];
    }
}
