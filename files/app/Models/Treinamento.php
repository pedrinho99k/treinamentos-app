<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treinamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'treinamento_setor_responsavel_id',
        'treinamento_m_treinamento_id',
        'treinamento_professor_id',
        'treinamento_data',
        'treinamento_carga_horaria',
        'treinamento_link_avaliaca_reacao',
        'treinamento_observacoes',
        'treinamento_ativo'
    ];

    public function MatrizTreinamento()
    {
        return $this->belongsTo(MatrizTreinamento::class, 'treinamento_m_treinamento_id');
    }

    public function Professor()
    {
        return $this->belongsTo(Professor::class, 'treinamento_professor_id');
    }

    public function Setor(){
        return $this->belongsTo(Setor::class,'treinamento_setor_responsavel_id');
    }

    public function listaPresencas()
    {
        return $this->hasMany(ListaPresenca::class, 'lp_treinamento_id');
    }

    // public function Cargos()
    // {
    //     return $this->belongsToMany(Cargo::class, 'treinamento_setor_responsavel_id');
    // }
}
