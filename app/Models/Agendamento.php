<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        "data_agendado",
        "data_agendamento",
        "hora",
        "lead_id",
        "negocio_id",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function negocio()
    {
        return $this->belongsTo("App\Models\Negocio");
    }

    public function reuniao()
    {
        return $this->hasOne("App\Models\Reuniao");
    }

}
