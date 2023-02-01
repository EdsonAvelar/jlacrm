<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NegocioStatus extends Enum
{
    const ATIVO = 'ATIVO';
    const INATIVO = 'INATIVO';
    const REATIVADO = 'REATIVADO';

    const VENDIDO = 'VENDIDO';
    const PERDIDO = 'PERDIDO';


    public static function all(){
        return ['ATIVO', 'INATIVO', 'REATIVADO','VENDIDO','PERDIDO'];
    }
}
