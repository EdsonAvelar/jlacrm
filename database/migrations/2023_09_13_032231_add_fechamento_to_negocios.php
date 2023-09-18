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
        Schema::table('negocios', function (Blueprint $table) {

            $table->integer('conjuge_id')->unsigned()->nullable();
            $table->foreign('conjuge_id')->references('id')->on('leads');

            $table->integer('fechamento_id')->unsigned()->nullable();
            $table->foreign('fechamento_id')->references('id')->on('fechamentos');
            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('negocios', function (Blueprint $table) {
            $table->dropForeign(['fechamento_id']);
            $table->dropForeign(['conjuge_id']);
        });
    }
};
