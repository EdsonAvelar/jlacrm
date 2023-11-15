<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulacaoConsorcio extends Model
{
    use HasFactory;

    public function simulacao()
    {
        return $this->belongsTo("App\Models\Simulacao");
    }

    

}
