<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fechamento extends Model
{
    use HasFactory;

    public function negocio()
    {
        return $this->hasOne("App\Models\Negocio");
    }

    public function vendedores()
    {
        return $this->belongsToMany("App\Models\User");
    }
}
