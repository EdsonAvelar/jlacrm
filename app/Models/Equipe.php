<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

     public function lider()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function integrantes()
    {
        return $this->hasMany("App\Models\User","equipe_id");
    }
}
