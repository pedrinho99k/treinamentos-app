<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizTreinamentoCargo extends Model
{
    use HasFactory;
    protected $table = 'matriz_treinamentos_cargos'; //Ajuste no nome para o entendimento do Laravel
    protected $fillable = ['id', 'm_treinamento_id', 'm_cargo_id'];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'm_cargo_id');
    }
    public function matriz_treinamento()
    {
        return $this->belongsTo(MatrizTreinamento::class, 'm_treinamento_id');
    }
}
