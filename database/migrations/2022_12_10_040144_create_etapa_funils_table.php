<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_funils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->enum('is_agendamento',['yes','no'])->nullable();
            $table->integer('ordem');
            $table->integer('funil_id')->unsigned();
            $table->foreign('funil_id')->references('id')->on('funils');
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
        Schema::dropIfExists('etapa_funils');
    }
};