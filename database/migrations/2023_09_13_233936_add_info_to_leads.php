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
        Schema::table('leads', function (Blueprint $table) {

        
            $table->string('nome_mae')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('data_nasc')->nullable();
            $table->string('orgao_exp')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('data_exp')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('naturalidade')->nullable();
            $table->string('genero')->nullable();
            $table->string('formacao')->nullable();
            $table->string('profissao')->nullable();
            $table->string('renda_liquida')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            //
        });
    }
};
