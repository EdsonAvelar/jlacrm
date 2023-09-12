<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\VendaStatus;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechamentos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('data_fechamento');
            $table->string('data_primeira_assembleia');

            $table->string('valor', 20);

            $table->enum('status', VendaStatus::all());

            //DADOS DO PLANO CONTRATADO
            $table->string('especie')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('codigo_bem')->nullable();
            $table->string('preco_bem')->nullable();
            $table->string('duracao_grupo')->nullable();
            $table->string('duracao_plano')->nullable();
            $table->string('tipo_plano')->nullable();
            $table->string('plano_leve')->nullable();
            $table->string('seguro_prestamista')->nullable();
            $table->string('grupo_em_formacao')->nullable();
            $table->string('grupo_em_andamento')->nullable();
            $table->string('numero_assembleia_adesao')->nullable();
            $table->string('data_assembleia')->nullable();
            $table->string('pagamento_incorporado')->nullable();
            $table->string('pagamento_ate_contemplacao')->nullable();
            $table->string('table')->nullable();

            // FORMA DE PAGAMENTO INICIAL
            $table->string('parcela')->nullable();
            $table->string('parcela_antecipada')->nullable();
            $table->string('total_antecipado')->nullable();
            $table->string('adesao')->nullable();
            $table->string('primeira_parcela')->nullable();
            $table->string('total_pago')->nullable();
            $table->string('forma_pagamento')->nullable();
            $table->integer('parcelas_embutidas');
                    

            // CHECAGEM DO ADMINISTRATIVO
            $table->string('doc_consorciado')->nullable();
            $table->string('doc_conjuge')->nullable();
            $table->string('comp_pagamento')->nullable();
            $table->string('comp_endereco')->nullable();
            $table->string('comp_venda')->nullable();
            $table->string('self_declaracao')->nullable();
            $table->string('controle_qualidade')->nullable();
            $table->string('video')->nullable();

            $table->text('comentarios')->nullable();


            $table->integer('negocio_id')->unsigned();
            $table->foreign('negocio_id')->references('id')->on('negocios');

            //conjude
            $table->integer('lead_id')->unsigned()->nullable();;
            $table->foreign('lead_id')->references('id')->on('leads');

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fechamentos');
    }
};
