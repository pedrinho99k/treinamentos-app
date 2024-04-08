<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;
    protected $table = 'setores'; //Ajuste no nome para o entendimento do Laravel
    protected $fillable = ['setor_descricao','setor_ativo'];
}
