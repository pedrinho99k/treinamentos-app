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
        Schema::create('lista_presencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lp_treinamento_id');
            $table->unsignedBigInteger('lp_colaborador_id');
            $table->string('lp_ativo')->default('SIM');
            $table->timestamps();

            $table->foreign('lp_treinamento_id')->references('id')->on('treinamentos');
            $table->foreign('lp_colaborador_id')->references('id')->on('colaboradores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_presencas');
    }
};
