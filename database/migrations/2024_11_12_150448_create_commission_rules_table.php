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
        Schema::create('commission_rules', function (Blueprint $table) {
            $table->id();
            $table->string('first_seller_role')->nullable(); // Cargo do primeiro vendedor
            $table->string('second_seller_role')->nullable(); // Cargo do segundo vendedor
            $table->string('condition_type'); // Tipo de condição (ex: 'Venda Solitária', 'Venda com Assistência')
            $table->decimal('commission_first', 5, 2); // Comissão do primeiro vendedor em %
            $table->decimal('commission_second', 5, 2)->nullable(); // Comissão do segundo vendedor em %
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
        Schema::dropIfExists('commission_rules');
    }
};
