<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\ListaPresenca;
use App\Http\Requests\StoreListaPresencaRequest;
use App\Http\Requests\UpdateListaPresencaRequest;
use App\Models\Treinamento;
use App\Models\TreinamentoRegistro;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ListaPresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $treinamento_id, Colaborador $colaborador)
    {
        // Consulte a lista de presença do treinamento especificado por $treinamento_id
        $treinamento = Treinamento::find($treinamento_id);

        if (!$treinamento) {
            return redirect()->route('treinamentos/treinamentos')->with('error', 'Treinamento não encontrado.');
        }

        // Consulte a lista de presença do treinamento
        $listaPresencas = $treinamento->listaPresencas()->with('colaborador')->get();

        // Recupere os colaboradores vinculados ao treinamento
        $colaboradores = Colaborador::join('matriz_treinamentos_cargos', 'colaboradores.colaborador_cargo_id', '=', 'matriz_treinamentos_cargos.m_cargo_id')
            ->where('matriz_treinamentos_cargos.m_treinamento_id', $treinamento_id)
            ->get();

        // Retorne a view com as informações do treinamento e seus colaboradores
        return view('lista_presenca.lista_presenca', compact('treinamento', 'listaPresencas', 'colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ListaPresenca $listaPresenca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListaPresenca $listaPresenca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateListaPresencaRequest $request, ListaPresenca $listaPresenca)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaPresenca $listaPresenca)
    {
        //
    }

    public function ListaColaboradoresTreinamento(Request $request)
    {
        $treinamento_id = $request->input('treinamento_id');

        // // Recupere os colaboradores vinculados ao treinamento
        // $colaboradores = Colaborador::join('matriz_treinamentos_cargos', 'colaboradores.colaborador_cargo_id', '=', 'matriz_treinamentos_cargos.m_cargo_id')
        //     ->join('cargos','colaboradores.colaborador_cargo_id','=','cargos.id')
        //     ->join('setores','colaboradores.colaborador_setor_id','=','setores.id')
        //     ->where('matriz_treinamentos_cargos.m_treinamento_id', $treinamento_id)
        //     ->orderBy('colaboradores.colaborador_nome', 'asc') // Ordenar por nome de colaborador em ordem ascendente
        //     ->get();

        $colaboradores = TreinamentoRegistro::join('colaboradores','treinamentos_registros.colaborador_id', '=', 'colaboradores.id')
            ->join('cargos', 'treinamentos_registros.cargo_id', '=', 'cargos.id')
            ->join('setores','colaboradores.colaborador_setor_id', '=', 'setores.id')
            ->where('treinamentos_registros.treinamento_id','=', $treinamento_id)
            ->orderBy('colaboradores.colaborador_nome', 'asc')
            ->get();

            // var_dump($colaboradores);

        return response()->json($colaboradores);

    }
}