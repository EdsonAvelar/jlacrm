<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funil extends Model
{
    use HasFactory;

    public function etapa_funils()
    {
        return $this->hasMany("App\Models\EtapaFunil");
    }

    public function leads()
    {
        return $this->belongToMany("App\Models\Lead");
    }

    public function negocios()
    {
        return $this->belongToMany("App\Models\Negocio");
    }
}