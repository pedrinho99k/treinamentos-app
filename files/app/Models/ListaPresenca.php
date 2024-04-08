<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPresenca extends Model
{
    use HasFactory;
    protected $table = 'lista_presencas'; //Ajuste no nome da tabela para o entendimento do Laravel
    protected $fillable = [
        'lp_treinamento_id',
        'lp_colaborador_id'
    ];

    public function Treinamento()
    {
        return $this->belongsTo(Treinamento::class, 'lp_treinamento_id');
    }

    public function Colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'lp_colaborador_id');
    }
}
