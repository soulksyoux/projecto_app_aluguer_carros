<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function regras() {
        return [
            "nome" => 'required|unique:marcas,nome,'.$this->id.'',
            "imagem" => "required",
        ];
    }

    public function mensagens() {
        return [
            "required" => "O campo :attribute é obrigatório",
            "nome.unique" => "O nome da marca já existe",
        ];
    }

    public function modelos()
    {
        return $this->hasMany("App\Models\Modelo");
    }
}
