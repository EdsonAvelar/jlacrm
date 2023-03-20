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
        Schema::create('propostas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('tipo',255);
            $table->string('banco',255);
            $table->string('credito',255);
            $table->string('fin-entrada',255);
            $table->string('fin-parcelas',255);
            $table->string('fin-prazo',255);
            $table->string('fin-rendaexigida',255);
            $table->string('cartorio',255);
            $table->string('fin-juros-pagos',255);
            $table->string('val-pago-total',255);
            $table->string('con-entrada',255);
            $table->string('con-parcelas',255);
            $table->string('con-prazo',255);
            $table->string('con-rendaexigida',255);
            $table->string('con-valor-pago',255);
            $table->string('reduzido',255);
            $table->string('parcelas_embutidas',255);

            $table->string('data_proposta',255);


            $table->integer('negocio_id')->unsigned();
            $table->foreign('negocio_id')->references('id')->on('negocios');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');


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
        Schema::dropIfExists('propostas');
    }
};
