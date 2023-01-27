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
        Schema::create('vendas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('data_fechamento');
            $table->string('data_primeira_assembleia');

            $table->string('valor', 20);

            $table->enum('status', VendaStatus::all());

            $table->integer('parcelas_embutidas');

            $table->integer('lead_id')->unsigned();
            $table->foreign('lead_id')->references('id')->on('leads');

            # proprietário do negócio
            $table->integer('vendedor_principal_id')->unsigned();
            $table->foreign('vendedor_principal_id')->references('id')->on('users');

             # proprietário do negócio
             $table->integer('vendedor_secundario_id')->unsigned()->nullable();
             $table->foreign('vendedor_secundario_id')->references('id')->on('users');

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
        Schema::dropIfExists('vendas');
    }
};
