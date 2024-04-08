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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('colaborador_nome',100);
            $table->integer('colaborador_codigo_esocial')->nullable();
            $table->text('colaborador_assinatura_png')->nullable();
            $table->unsignedBigInteger('colaborador_cargo_id');
            $table->unsignedBigInteger('colaborador_setor_id');
            $table->string('colaborador_ativo',3)->default('SIM');
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('colaborador_cargo_id')->references('id')->on('cargos');
            $table->foreign('colaborador_setor_id')->references('id')->on('setores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
