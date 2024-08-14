<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;



final class LevantamentoStatus extends Enum
{
    const REJEITADO = 0;
    const EM_APROVACAO = 1;

    const APROVADO = 2;

    public static function all()
    {
        return array('EM APROVAÇÃO', 'REJEITADO', 'APROVADO');
    }

    public static function get(int $value): string
    {
        switch ($value) {
            case self::rejeitado:
                return 'REJEITADO';
            case self::em_aprovacao:
                return 'EM APROVAÇÃO';
            case self::aprovado:
                return 'APROVADO';
            default:
                return self::getKey($value);
        }
    }
}
