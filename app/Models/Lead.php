<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;


    public function users()
    {
        return $this->belongsTo("App\Models\User");
    }


    public function funil()
    {
        return $this->belongsTo("App\Models\Funil");
    }

    public function etapa_funil()
    {
        return $this->belongsTo("App\Models\EtapaFunil");
    }

    public function negocios()
    {
        return $this->hasMany("App\Models\Negocio");
    }

}