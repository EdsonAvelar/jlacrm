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
        Schema::table('fechamentos', function (Blueprint $table) {
            $table->decimal('comissao_1', 15, 4)->nullable()->after('terceiro_vendedor_id'); // Substitua 'existing_column' pelo nome da última coluna da tabela
            $table->decimal('comissao_2', 15, 4)->nullable()->after('comissao_1');
            $table->decimal('comissao_3', 15, 4)->nullable()->after('comissao_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fechamentos', function (Blueprint $table) {
            $table->dropColumn(['comissao_1', 'comissao_2', 'comissao_3']);

        });
    }
};
