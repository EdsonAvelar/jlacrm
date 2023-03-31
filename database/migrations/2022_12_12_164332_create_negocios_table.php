<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\NegocioStatus;
use App\Enums\NegocioTipo;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negocios', function (Blueprint $table) {
            $table->increments('id');

            $table->string('fechamento')->nullable();

            $table->string('titulo');
            $table->string('valor', 20);
            $table->string('entrada', 20);
            
            
            $table->enum('tipo', NegocioTipo::all());
            $table->enum('status', NegocioStatus::all());

            $table->integer('lead_id')->unsigned();
            $table->foreign('lead_id')->references('id')->on('leads');

            $table->integer('funil_id')->unsigned();
            $table->foreign('funil_id')->references('id')->on('funils');
            $table->integer('etapa_funil_id')->unsigned();
            $table->foreign('etapa_funil_id')->references('id')->on('etapa_funils');


            # proprietário do negócio
            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('negocios');
    }
};