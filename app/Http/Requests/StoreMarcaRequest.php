<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcaRequest extends FormRequest
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
            "nome" => 'required|unique:marcas',
            "imagem" => "required|file|mimes:png",
        ];
    }

    public function messages(){
        return [
            "required" => "O campo :attribute é obrigatório",
            "nome.unique" => "O nome da marca já existe",
            "imagem.file" => "Tipo de input inválido",
            "imagem.mimes" => "Formato de imagem inválido, tem de ser png",
        ];
    }
}
