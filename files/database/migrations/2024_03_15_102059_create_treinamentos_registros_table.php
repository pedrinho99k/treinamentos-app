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
        Schema::create('treinamentos_registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treinamento_id');
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('colaborador_id');
            $table->string('treinamento_realizado',3)->default('SIM');
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('treinamento_id')->references('id')->on('treinamentos');
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treinamentos_registros');
    }
};
