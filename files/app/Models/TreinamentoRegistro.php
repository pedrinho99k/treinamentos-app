<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreinamentoRegistro extends Model
{
    use HasFactory;

    protected $table = 'treinamentos_registros';
    
    protected $fillable = [
        'id',
        'm_treinamento_id',
        'm_cargo_id',
        'colaborador_id',
        'treinamento_realizado'
    ];

    public function treinamento()
    {
        return $this->belongsTo(Treinamento::class, 'm_treinamento_id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'm_cargo_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_nome');
    }
}
