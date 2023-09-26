<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Planejamento extends Enum
{
    const ATE_3_MESES = 'ATE_3_MESES';
    const ATE_6_MESES = 'ATE_6_MESES';
    const ATE_12_MESES = 'ATE_12_MESES';
    const MAIS_12_MESES = 'MAIS_12_MESES';

    public static function all(){
        return array('ATE_3_MESES', 'ATE_6_MESES', 'ATE_12_MESES', 'MAIS_12_MESES');
    }

}
