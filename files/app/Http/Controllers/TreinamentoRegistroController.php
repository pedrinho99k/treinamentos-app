<?php

namespace App\Http\Controllers;

use App\Models\Treinamento;
use App\Models\TreinamentoRegistro;
use App\Models\Cargo;
use App\Models\MatrizTreinamento;
use App\Models\MatrizTreinamentoCargo;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreinamentoRegistroController extends Controller
{
    public function buscarMatrizCargo (Request $request)
    {
        // Recebe o matriz_id do ajax da pagina blade
        $id = $request->input('matriz_id');

        // Realiza a consulta no banco de dados e retorna o id dos cargos
        $matrizTreinamentosCargos = MatrizTreinamentoCargo::where('m_treinamento_id', $id)
            ->get();

        $id_cargos = $matrizTreinamentosCargos->pluck('m_cargo_id')->toArray();

        $matrizCargosDescricao = Cargo::whereIn('id', $id_cargos)
            ->get();

        $colaboradoresCargos = Colaborador::whereIn('colaborador_cargo_id', $id_cargos)
            ->get();

    
        return response()->json([
            'cargo' => $matrizCargosDescricao,
            'colaboradores_cargos' => $colaboradoresCargos
        ]);
    }
}
