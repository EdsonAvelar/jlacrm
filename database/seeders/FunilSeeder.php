<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Funil;
use App\Models\EtapaFunil;

class FunilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createFunil();
        $this->command->info('Criando um funil padrão');
    }


    private function createFunil()
    {
        $funil = new Funil();
        $funil->nome = 'VENDAS';
        $funil->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "OPORTUNIDADE";
        $etapa->funil_id = $funil->id;
        $etapa->ordem = 1;
        $etapa->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "PRIMEIRO_CONTATO";
        $etapa->funil_id = $funil->id;
        $etapa->ordem = 2;
        $etapa->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "REUNIAO_AGENDADA";
        $etapa->funil_id = $funil->id;
        $etapa->is_agendamento = "yes";
        $etapa->ordem = 3;
        $etapa->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "REUNIAO";
        $etapa->funil_id = $funil->id;
        $etapa->is_agendamento = "yes";
        $etapa->ordem = 4;
        $etapa->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "APROVACAO";
        $etapa->funil_id = $funil->id;
        $etapa->ordem = 5;
        $etapa->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "ACOMPANHAMENTO";
        $etapa->funil_id = $funil->id;
        $etapa->ordem =6;
        $etapa->save();

        $etapa = new EtapaFunil();
        $etapa->nome = "FECHAMENTO";
        $etapa->funil_id = $funil->id;
        $etapa->ordem = 7;
        $etapa->save();

    }
}