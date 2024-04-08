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
        Schema::create('treinamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treinamento_setor_responsavel_id');
            $table->unsignedBigInteger('treinamento_m_treinamento_id');
            $table->unsignedBigInteger('treinamento_professor_id');
            $table->date('treinamento_data');
            $table->time('treinamento_carga_horaria');
            $table->text('treinamento_link_avaliaca_reacao')->nullable();
            $table->text('treinamento_observacoes')->nullable();
            $table->string('treinamento_ativo')->default('SIM');
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('treinamento_setor_responsavel_id')->references('id')->on('setores');
            $table->foreign('treinamento_m_treinamento_id')->references('id')->on('matriz_treinamentos');
            $table->foreign('treinamento_professor_id')->references('id')->on('professores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treinamentos');
    }
};
