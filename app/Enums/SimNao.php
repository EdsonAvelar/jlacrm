<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SimNao extends Enum
{
    const SIM = 'SIM';
    const NAO = 'NAO';

    public static function all(){
        return array('SIM', 'NAO');
    }

}
