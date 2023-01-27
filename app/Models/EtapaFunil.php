<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapaFunil extends Model
{
    use HasFactory;

    public function funils()
    {
        return $this->belongsTo("App\Models\Funil");
    }

    
}
