<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Lead;
use \App\Models\Funil;


class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createLeads();
    }


    private function createLeads(){

        
        
        $faker = \Faker\Factory::create('pt_BR');

        for ($i=1; $i<50; $i++) {

            $lead = new Lead();
            $lead->nome =  $faker->name;
            $lead->telefone = 11123123121;
            $lead->whsa = 12321312321;
            $lead->titulo = sprintf( 'Imovel %s00',$i) ;
            $lead->email = $faker->email;

            $lead->endereco = $faker->address;
                      
            $lead->save();
           
        }

       

        
       
    }

}
