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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar');

            $table->string('telefone')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('endereco')->nullable();
            $table->string('pix')->nullable();
            $table->string('data_contratacao')->nullable();
            $table->string('data_demissao')->nullable();

            $table->integer('status')->unsigned();

            $table->integer('equipe_id')->unsigned()->nullable();
            $table->foreign('equipe_id')->references('id')->on('equipes');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
