<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Tabela extends Enum
{
    const CIMA = 'CIMA';
    const BAIXO = 'BAIXO';

    public static function all(){
        return array('CIMA', 'BAIXO');
    }

}
