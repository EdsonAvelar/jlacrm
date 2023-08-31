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
        Schema::create('vendas2', function (Blueprint $table) {
            $table->increments('id');

            $table->string('data_fechamento');
            $table->string('data_primeira_assembleia');

            #$table->string('valor', 20);

            $table->enum('status', VendaStatus::all());

            $table->integer('parcelas_embutidas');

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
        Schema::dropIfExists('vendas2');
    }
};
