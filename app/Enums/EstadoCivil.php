<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class EstadoCivil extends Enum
{
    const SOLTEIRO = 'SOLTEIRO';
    const CASADO = 'CASADO';
    const SEPARADO = 'SEPARADO';
    const DIVORCIADO = 'DIVORCIADO';
    const VIUVO = 'VIUVO';



    public static function all(){
        return ['SOLTEIRO','CASADO','SEPARADO','DIVORCIADO','VIUVO' ];
    }
}
