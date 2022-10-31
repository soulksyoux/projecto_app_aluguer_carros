<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModeloRequest extends FormRequest
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
            "marca_id" => 'exists:marcas,id',
            "nome" => 'unique:modelos,nome,'.$this->modelo.'',
            "imagem" => "file|mimes:png",
            "numero_portas" => "integer",
            "lugares" => "integer",
            "airbag" => "boolean",
            "abs" => "boolean",
        ];
    }

    public function messages() 
    {
        return [
            "marca_id.exists" => "O campo marca_id é inválido",
            "nome.unique" => "O campo nome já existe no sistema",
            "integer" => "O campo :attribute não é numérico",
            "imagem.mimes" => "A imagem tem de ser do formato PNG",
            "boolean" => "O campo :attribute não é boleano",
        ];
    }
}
