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
        Schema::create('matriz_treinamentos_cargos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('m_treinamento_id');
            $table->unsignedBigInteger('m_cargo_id');
            $table->string('matriz_treinamento_cargo',3)->default('SIM');
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('m_treinamento_id')->references('id')->on('matriz_treinamentos');
            $table->foreign('m_cargo_id')->references('id')->on('cargos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriz_treinamentos_cargos');
    }
};
