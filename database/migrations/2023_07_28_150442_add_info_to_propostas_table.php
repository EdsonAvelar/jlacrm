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
        Schema::table('propostas', function (Blueprint $table) {
            
            $table->string('con-credito',255);
            $table->string('con-juros-pagos',255);
            $table->string('con-adesao',255);
            $table->string('vitbi',255)->nullable();
            $table->string('modelo',255)->nullable();
            $table->string('ano',255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('propostas', function (Blueprint $table) {
            //
        });
    }
};
