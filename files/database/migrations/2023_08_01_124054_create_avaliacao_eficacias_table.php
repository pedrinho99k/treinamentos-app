<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacao_eficacias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('avaliacao_eficacia_treinamento_id');
            $table->unsignedBigInteger('avaliacao_eficacia_cargo_id');
            $table->date('avaliacao_aficacia_data');
            $table->string('avaliacao_eficacia_tipo_ferramenta');
            $table->longtext('avaliacao_eficacia_analise');
            $table->string('avaliacao_eficacia_eficaz');
            $table->longtext('avaliacao_eficacia_acao')->nullable();
            $table->timestamps();

            //FOREIGN KEY
            $table->foreign('avaliacao_eficacia_treinamento_id')->references('id')->on('treinamentos');
            $table->foreign('avaliacao_eficacia_cargo_id')->references('id')->on('cargos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao_eficacias');
    }
};
