<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DificuldadeTipo extends Enum
{
    const PARCELAMENTO = 'PARCELAMENTO';
    const ENCONTRAR_BEM = 'ENCONTRAR_BEM';
    const LEVANTAR_ENTRADA = 'LEVANTAR_ENTRADA';
    const PAGAR_PARCELA = 'PAGAR_PARCELA';
    const COMPROVAR_RENDA = 'COMPROVAR_RENDA';

    public static function all(){
        return array('PARCELAMENTO', 'ENCONTRAR_BEM', 'LEVANTAR_ENTRADA', 'PAGAR_PARCELA', 'COMPROVAR_RENDA');
    }

}
