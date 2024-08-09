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
    const CANCELADA = 'CANCELADA';
    const RASCUNHO = 'RASCUNHO';

    public static function all()
    {
        return array('FECHADA', 'CANCELADA', 'RASCUNHO');
    }

}
