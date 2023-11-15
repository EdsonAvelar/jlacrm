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
        "valor",
        "lead_id",
        "user_id",
        "tipo",
        "data_criacao",
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

    public function levantamento()
    {
        return $this->belongsTo("App\Models\Levantamento");
    }

    public function fechamento()
    {
        return $this->belongsTo("App\Models\Fechamento");
    }
 

    public function propostas()
    {
        return $this->hasMany("App\Models\Proposta");
    }

    public function simulacoes()
    {
        return $this->hasMany("App\Models\Simulacao");
    }

    public function etapa_funil()
    {
        return $this->belongsTo("App\Models\EtapaFunil");
    }

    public function lead()
    {
        return $this->belongsTo("App\Models\Lead");
    }
    public function conjuge()
    {
        return $this->belongsTo("App\Models\Lead","conjuge_id");
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