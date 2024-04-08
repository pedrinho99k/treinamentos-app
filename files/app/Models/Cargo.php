<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargos'; //Ajuste no nome para o entendimento do Laravel
    protected $fillable = ['id','cargo_descricao','cargo_ativo'];
    
}
