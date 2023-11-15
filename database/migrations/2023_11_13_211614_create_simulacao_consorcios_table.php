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
        Schema::create('simulacao_consorcios', function (Blueprint $table) {

            $table->increments('id');
            //Consorcio - Proposta 1
            $table->string('con-titulo',255)->nullable();
            $table->string('con-empresa',255)->nullable();
            $table->string('con-credito',255)->nullable();
            $table->string('con-adesao',255)->nullable();
            $table->string('con-entrada',255)->nullable();
            $table->string('con-parcela-cheia',255)->nullable();
            $table->string('con-parcela-reduzida',255)->nullable();
            $table->string('con-lance',255)->nullable();
            $table->string('con-prazo',255)->nullable();
            $table->string('con-rendaexigida',255)->nullable();
            $table->string('con-valor-pago',255)->nullable();
            $table->string('con-juros-pagos',255)->nullable();
            $table->string('con-parcelas_embutidas',255)->nullable();

            $table->integer('simulacao_id')->unsigned();
            $table->foreign('simulacao_id')->references('id')->on('simulacaos');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('simulacao_consorcios');
    }
};
