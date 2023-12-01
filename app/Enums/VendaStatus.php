<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VendaStatus extends Enum
{
    const FECHADA = 'FECHADA';
    const ENVIADA = 'ENVIADA';
    const TROCA_CONTRATO = 'TROCA_CONTRATO';
    const CANCELADA = 'CANCELADA';
    const BORDERO = 'BORDERO';
    const CHECADA = 'CHECADA';

    public static function all(){
        return array('FECHADA', 'ENVIADA', 'TROCA_CONTRATO', 'CANCELADA', 'CHECADA', 'BORDERO');
    }

}
