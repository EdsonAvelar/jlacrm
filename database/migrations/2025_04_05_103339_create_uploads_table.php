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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();

            $table->string('file_name');
            $table->string('file_path');
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->integer('negocio_id')->unsigned();
            $table->foreign('negocio_id')->references('id')->on('negocios')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
};
