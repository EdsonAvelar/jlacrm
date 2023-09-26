<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ComprovacaoRenda extends Enum
{
    const IMPOSTO_RENDA = 'IMPOSTO_RENDA';
    const HOLERITE = 'HOLERITE';

    public static function all(){
        return ['IMPOSTO_RENDA','HOLERITE'];
    }
}
