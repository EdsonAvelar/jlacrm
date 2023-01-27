<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

   

final class UserStatus extends Enum
{
    const inativo = 0;
    const ativo = 1;


    public static function get(int $value): string
    {
        switch ($value) {
            case self::ativo:
                return 'Ativo';
            case self::inativo:
                return 'Inativo';
            default:
                return self::getKey($value);
        }
    }
}
