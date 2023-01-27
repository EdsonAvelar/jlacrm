<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;


    public function vendedor_secundario()
    {
        return $this->belongsTo("App\Models\User");
    }


    public function vendedor_principal()
    {
        return $this->belongsTo("App\Models\User");
    }
 
    public function lead()
    {
        return $this->belongsTo("App\Models\Lead");
    }
}
