<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'url', 'token', 'endereco', 'cidade', 'estado', 'telefone'];

    #protected $hidden = ['token']; // Oculta o token na resposta JSON
}
