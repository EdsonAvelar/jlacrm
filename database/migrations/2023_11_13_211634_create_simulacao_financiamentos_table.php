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
        Schema::create('simulacao_financiamentos', function (Blueprint $table) {
            
            $table->increments('id');
            //Financiamento
            
            $table->string('fin-titulo',255)->nullable();
            $table->string('fin-amortizacao',255)->nullable();
            $table->string('fin-empresa',255)->nullable();
            $table->string('fin-credito',255)->nullable();
            $table->string('fin-entrada',255)->nullable();
            $table->string('fin-parcelas',255)->nullable();
            $table->string('fin-prazo',255)->nullable();
            $table->string('fin-rendaexigida',255)->nullable();
            $table->string('fin-cartorio',255)->nullable();
            $table->string('fin-juros-pagos',255)->nullable();
            $table->string('fin-val-pago-total',255)->nullable();

            $table->integer('simulacao_id')->unsigned();
            $table->foreign('simulacao_id')->references('id')->on('simulacaos');


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
        Schema::dropIfExists('simulacao_financiamentos');
    }
};
