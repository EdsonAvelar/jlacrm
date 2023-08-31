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
        Schema::create('vendedor_vendas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('porcentagem')->unsigned();
            $table->integer('data_comissao')->unsigned();

             # proprietário do negócio
            $table->integer('vendedor_id')->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('users');

            $table->integer('venda_id')->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas');

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
        Schema::dropIfExists('vendedor_vendas');
    }
};
