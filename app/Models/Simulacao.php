<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulacao extends Model
{
    use HasFactory;

    public function consorcios()
    {
        return $this->hasMany("App\Models\SimulacaoConsorcio");
    }


    public function financiamentos()
    {
        return $this->hasMany("App\Models\SimulacaoFinanciamento");
    }

   

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function negocio()
    {
        return $this->belongsTo("App\Models\Negocio");
    }


}
