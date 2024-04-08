<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizTreinamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'm_treinamento_descricao',
        'm_treinamento_tempo',
        'm_treinamento_obrigatorio',
        'm_treinamento_obrigatorio_avaliacao_eficacia',
        'm_treinamento_setor_responsavel_id',
        'm_treinamento_ativo'
    ];

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'm_treinamento_setor_responsavel_id');
    }

    public function cargos()
    {
        return $this->hasMany(MatrizTreinamentoCargo::class, 'm_treinamento_id');
    }
}
