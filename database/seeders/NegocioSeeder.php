<?php

namespace Database\Seeders;

use App\Models\Negocio;
use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Funil;
use App\Models\NegocioComentario;
use App\Enums\NegocioTipo;
use App\Enums\NegocioStatus;
use Carbon\Carbon;

class NegocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create('pt_BR');

        for ($i = 1; $i < 1000; $i++) {

            $negocio = new Negocio();
            $negocio->titulo = "Casa 100k " . $faker->name;
            $negocio->valor = $i * 100000;
            $negocio->tipo = 1;
            $negocio->funil_id = 1;
            $negocio->data_criacao =Carbon::now();
            $negocio->fechamento = "18/12/2022";

            /**
             * Criando lead para associar ao negócio
             */
            $lead = new Lead();
            $lead->nome = $faker->name;
            $lead->telefone = $faker->phoneNumber;
            $lead->whatsapp = $faker->phoneNumber;
            $lead->email = $faker->email;

            $lead->endereco = $faker->address;
            $lead->complemento = $faker->address;
            $lead->cep = $faker->postcode;
            $lead->save();

            //Associando o lead ao negócio
            $negocio->lead_id = $lead->id;


            $input = NegocioTipo::all();
            $negocio->tipo = $input[array_rand($input)];


            $negocio->status = NegocioStatus::ATIVO;

            //Associando etapa de funil
            $negocio->etapa_funil_id = random_int(1, 5);
            $negocio->user_id = 1;

            //Comentarios
            $negocio->save();


            //Criando comentários e associando ao negocio
            $comentario = new NegocioComentario();
            $comentario->user_id = 1;
            $comentario->negocio_id = $negocio->id;
            $comentario->comentario = $faker->text();
            $comentario->save();


            
        }

    }
}