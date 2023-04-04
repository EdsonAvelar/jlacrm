<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Atividade extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public static function add_atividade($user_id, $descricao, $negocio_id)
    {
        $atv = new Atividade();
        
        if ($user_id){
            $atv->user_id = $user_id;
        }else {
            $atv->user_id = NULL;
        }
        $atv->descricao  = $descricao;
        $atv->data_atividade =  Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i:s');
        $atv->negocio_id = $negocio_id;
        $atv->save();
    }

}
