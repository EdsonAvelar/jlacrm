<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    use HasFactory;

    protected $fillable = [
        "titulo",
        "funil_id",
        "lead_id",
        "user_id",
        "etapa_funil_id"
    ];

    public function funil()
    {
        return $this->belongsTo("App\Models\Funil");
    }

    public function atividades()
    {
        return $this->hasMany("App\Models\Atividade");
    }


    public function agendamento()
    {
        return $this->belongsTo("App\Models\Agendamento");
    }
 

    public function propostas()
    {
        return $this->hasMany("App\Models\Proposta");
    }

    public function etapa_funil()
    {
        return $this->belongsTo("App\Models\EtapaFunil");
    }

    public function lead()
    {
        return $this->belongsTo("App\Models\Lead");
    }


    public function comentarios()
    {
        return $this->hasMany("App\Models\NegocioComentario");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}