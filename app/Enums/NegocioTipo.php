<?php declare(strict_types=1);

namespace App\Enums;
use BenSampo\Enum\Enum;


final class NegocioTipo extends Enum
{
    const IMOVEL = 'IMOVEL';
    const CARRO = 'CARRO';
    const MOTO = 'MOTO';
    const CAMINHAO = 'CAMINHAO';
    const TERRENO = 'TERRENO';
    const MAQUINARIO = 'MAQUINARIO';
    const SERVICO = 'SERVICO';

    public static function all(){
        return ['IMOVEL', 'CARRO','MOTO', 'CAMINHAO','TERRENO', 'MAQUINARIO', 'SERVICO'] ;
    }
    
}
