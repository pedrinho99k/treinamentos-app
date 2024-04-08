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
        Schema::create('matriz_treinamentos', function (Blueprint $table) {
            $table->id();
            $table->string('m_treinamento_descricao',100);
            $table->time('m_treinamento_tempo',$precision = 0);
            $table->string('m_treinamento_obrigatorio',3)->nullable();
            $table->string('m_treinamento_obrigatorio_avaliacao_eficacia',3)->nullable();
            $table->unsignedBigInteger('m_treinamento_setor_responsavel_id');
            $table->string('m_treinamento_ativo',3)->default('SIM');
            $table->timestamps();

            //FOREIGN KEY
            $table->foreign('m_treinamento_setor_responsavel_id')->references('id')->on('setores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriz_treinamentos');
    }
};
