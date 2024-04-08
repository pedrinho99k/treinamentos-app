<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;
    protected $table = 'colaboradores'; //Ajuste no nome para o entendimento do Laravel
    protected $fillable = [
        'colaborador_nome',
        'colaborador_codigo_esocial',
        'colaborador_assinatura_png',
        'colaborador_cargo_id',
        'colaborador_setor_id',
        'colaborador_ativo'];

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'colaborador_setor_id');
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'colaborador_cargo_id');
    }

}
