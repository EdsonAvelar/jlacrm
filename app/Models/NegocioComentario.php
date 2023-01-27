<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegocioComentario extends Model
{
    use HasFactory;


    public function lead()
    {
        return $this->belongsTo("App\Models\Lead");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}