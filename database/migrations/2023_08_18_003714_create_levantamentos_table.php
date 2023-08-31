<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levantamentos', function (Blueprint $table) {

            $table->increments('id');

            #$table->enum('tipo', NegocioTipo::all()); --Pega do negócio
            $table->string('dificuldade')->nullable();
            $table->string('regiao')->nullable();
            #$table->string('valor_bem')->nullable(); --Pega do negócio
            $table->string('parcela_max')->nullable();
            $table->string('entrada_max')->nullable();
            $table->string('desfazer_bem')->nullable();
            $table->string('aluguel')->nullable();
            $table->string('decisores')->nullable();

            # Valor de FGTS
            $table->string('valor_fgts')->nullable();
            $table->string('compor_renda')->nullable();
            $table->string('financiamento')->nullable();
            $table->string('filhos')->nullable();
            $table->string('status_civil')->nullable();
            $table->string('casa_propria')->nullable();
            $table->string('renda_total')->nullable();
            $table->string('renda_comprovacao')->nullable();
            $table->string('restricao')->nullable();



            $table->integer('negocio_id')->unsigned();
            $table->foreign('negocio_id')->references('id')->on('negocios');

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
        Schema::dropIfExists('levantamentos');
    }
};
