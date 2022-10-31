<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ["nome"];

    public function locacoes() {
        return $this->hasMany("App\Models\Locacao");
    }
}
