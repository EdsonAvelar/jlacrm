<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Produtos extends Enum
{
    const FINANCIAMENTO = 'FINANCIAMENTO';
    const EMPRESTIMO = 'EMPRESTIMO';
    const ACORDOS = 'ACORDOS';
    const CONSORCIO = 'CONSORCIO';


    public static function all(){
        return array('FINANCIAMENTO', 'EMPRESTIMO', 'ACORDOS', 'CONSORCIO');
    }

}
