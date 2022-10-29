<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ["marca_id", "nome", "imagem", "numero_portas", "lugares", "airbag", "abs"]; 
 
    public function marca() {
        return $this->belongsTo("App\Models\Marca");
    }


}
