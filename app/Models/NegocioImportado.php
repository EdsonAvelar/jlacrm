<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegocioImportado extends Model
{

    use HasFactory;
    
    protected $fillable = [
        "nome",
        "telefone",
        "email",
        "campanha",
        "fonte",
        "convertido_em"
    ];

   
}
