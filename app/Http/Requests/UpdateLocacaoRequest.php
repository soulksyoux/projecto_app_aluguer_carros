<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocacaoRequest extends FormRequest
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
            "cliente_id" => 'exists:clientes,id',
            "carro_id" => 'exists:carros,id',
            "data_inicio_periodo" => "date",
            "data_final_previsto_periodo" => "date",
            "data_final_realizado_periodo" => "date",
            "valor_diaria" => "numeric",
            "km_inicial" => "integer|min:0",
            "km_final" => "integer|min:0",
        ];
    }

    public function messages()
    {
        return [
            "cliente_id.exists" => "O campo cliente id é inválido",
            "carro_id.exists" => "O campo carro id é inválido",
            "datetime" => "O campo :attribute tem de ser date",
            "boolean" => "O campo :attribute tem de ser boolean",
            "integer" => "O campo :attribute tem de ser inteiro",
            "numeric" => "O campo :attribute tem de ser numeric",
            "km_inicial:min" => "O minimo para km iniciais é de 0", 
            "km_final:min" => "O minimo para km finais é de 0", 
        ];
    }
}
