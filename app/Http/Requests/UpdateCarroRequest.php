<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCarroRequest extends FormRequest
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
            "modelo_id" => 'exists:modelos,id',
            "placa" => 'unique:carros,placa,'.$this->carro.'',
            "disponivel" => "boolean",
            "km" => "integer",
        ];
    }

    public function messages()
    {
        return [
            "modelo_id.exists" => "O campo modelo id é inválido",
            "placa.unique" => "O campo placa tem de ser unico",
            "boolean" => "O campo :attribute tem de ser boolean",
            "integer" => "O campo :attribute tem de ser numérico",
        ];
    }
}
