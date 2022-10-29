<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class StoreModeloRequest extends FormRequest
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
            "nome" => 'required|unique:modelos',
            "imagem" => "required|file|mimes:png",
            "numero_portas" => "required|integer|digits_between:1,5",
            "lugares" => "required|integer|digits_between:1,7",
            "airbag" => "required|boolean",
            "abs" => "required|boolean",
        ];
    }

    public function messages() 
    {
        return [
            "required" => "O campo :attribute é obrigatório",
            "marca_id.exists" => "O campo marca_id é inválido",
            "nome.unique" => "O campo nome já existe no sistema",
            "integer" => "O campo :attribute não é numérico",
            "imagem.mimes" => "A imagem tem de ser do formato PNG",
            "boolean" => "O campo :attribute não é boleano",
        ];
    }
}
