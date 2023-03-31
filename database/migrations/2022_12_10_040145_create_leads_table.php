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
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 254);
            $table->string('telefone', 32);
            $table->string('whatsapp', 32)->nullable();
            $table->string('email', 254)->nullable();
            
            # campanhas
            $table->string('data_conversao', 254)->nullable();
            $table->string('fonte', 254)->nullable();
            $table->string('campanha', 254)->nullable();

            $table->string('endereco', 254)->nullable();
            $table->string('complemento', 254)->nullable();
            $table->string('cep', 254)->nullable();
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
        Schema::dropIfExists('leads');
    }
};