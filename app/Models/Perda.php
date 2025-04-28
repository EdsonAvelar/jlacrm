<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perda extends Model
{
    use HasFactory;

    protected $table = 'perdas';
    protected $fillable = ['negocio_id', 'motivo_perdas_id'];

    public function negocio()
    {
        return $this->belongsTo(Negocio::class, 'negocio_id');
    }

    public function motivo()
    {
        return $this->belongsTo(MotivoPerda::class, 'motivo_perdas_id');
    }
}
