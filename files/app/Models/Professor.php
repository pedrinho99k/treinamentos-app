<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    protected $table = 'professores'; //Ajuste no nome para o entendimento do Laravel
    protected $fillable = ['professor_nome', 'professor_interno', 'professor_colaborador_id', 'professor_ativo'];

}
