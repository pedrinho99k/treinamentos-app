<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use App\Models\ListaPresenca;
use App\Models\Setor;
use App\Models\Cargo;
use App\Models\Treinamento;
use App\Models\MatrizTreinamento;
use App\Models\TreinamentoRegistro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class TreinamentoPresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        // Consulte a lista de presença do treinamento especificado por $treinamento_id
        $treinamentos = TreinamentoRegistro::where('treinamento_id', $id)->get();

        // $treinamentos_registro = $treinamentos->toArray();

        // Verificar se existe o treinamento
        // if (!$treinamentos) {
        //     return redirect()->route('treinamentos/treinamentos')->with('error', 'Treinamento não encontrado.');
        // }


        $array = [];
        foreach ($treinamentos as $treinamento) {
            $colaborador = Colaborador::find($treinamento->colaborador_id);

            if ($colaborador) {
                $cargo = Cargo::find($colaborador->colaborador_cargo_id);
                $setor = Setor::find($colaborador->colaborador_setor_id);
                $registro_colaboradores = TreinamentoRegistro::where('colaborador_id', $colaborador['id'])->get();

                $dadosColaborador = [
                    'id' => $colaborador->id,
                    'registro_colaboradores' => $registro_colaboradores,
                    'colaborador_nome' => $colaborador->colaborador_nome,
                    'setor_descricao' => $setor ? $setor->setor_descricao : null,
                    'cargo_descricao' => $cargo ? $cargo->cargo_descricao : null,
                ];
                
                // $treinamento->dados_colaborador = $dadosColaborador;

                $array[] = $dadosColaborador;
            }
        };

        $treinamento = MatrizTreinamento::find($id);








        // $cargos_totais = MatrizTreinamentoCargo::where('m_treinamento_id', $id)->pluck('m_cargo_id')->toarray();

        // $colaboradores_totais = Colaborador::where('colaborador_cargo_id', $cargos_totais)
        //     ->where('colaborador_ativo', 'SIM')
        //     ->get();
        
        // // $cargo = Cargo::find($colaboradores_totais->cargo_descricao);
        
        // foreach ($colaboradores_totais as $colaborador) {
        //     $cargo_id = $colaborador['colaborador_cargo_id'];
        //     $cargo = Cargo::find($cargo_id);
        //     $cargo_descricao = $cargo->cargo_descricao;

        //     $setor_id = $colaborador['colaborador_setor_id'];
        //     $setor = Setor::find($setor_id);
        //     $setor_descricao = $setor->setor_descricao;


        //     $dadosColaborador = [
        //         'id' => $colaborador['id'],
        //         'colaborador_nome' => $colaborador['colaborador_nome'],
        //         'colaborador_codigo_esocial' => $colaborador['colaborador_codigo_esocial'],
        //         'colaborador_codigo_secundario' => $colaborador['colaborador_codigo_secundario'],
        //         'colaborador_assinatura_png' => $colaborador['colaborador_assinatura_png'],
        //         'colaborador_cargo_id' => $colaborador['colaborador_cargo_id'],
        //         'colaborador_setor_id' => $colaborador['colaborador_setor_id'],
        //         'colaborador_ativo' => $colaborador['colaborador_ativo'],
        //     ];

        //     $array[] = $dadosColaborador;
        //     $cargos[] = $cargo_descricao;
        //     // $setor[] = $setor_descricao;
        // }





        // foreach ($treinamentos as $treinamento) {
        //     $treinamento->get('colaborador_id');
        // }


        // if (!$treinamento) {
        //     return redirect()->route('treinamentos/treinamentos')->with('error', 'Treinamento não encontrado.');
        // }

        // // Consulte a lista de presença do treinamento
        // $listaPresencas = $treinamento->listaPresencas()->with('colaborador')->get();

        // // Recupere os colaboradores vinculados ao treinamento
        // $colaboradores = Colaborador::join('matriz_treinamentos_cargos', 'colaboradores.colaborador_cargo_id', '=', 'matriz_treinamentos_cargos.m_cargo_id')
        //     ->where('matriz_treinamentos_cargos.m_treinamento_id', $treinamento_id)
        //     ->get();

        // Retorne a view com as informações do treinamento e seus colaboradores
        return view('treinamentos_presenca.treinamentos_presenca', compact('array', 'id', 'treinamento'));
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





    public function update(Request $request)
    {
        $dados = $request->input();

        $treinamento_id = $request->input('id');

        $colaboradores_selecionados = $request->input('checkboxes');

        TreinamentoRegistro::where('treinamento_id', $treinamento_id)
            ->whereNotIn('colaborador_id', $colaboradores_selecionados)
            ->update(['treinamento_realizado' => 'NÃO']);

        TreinamentoRegistro::where('treinamento_id', $treinamento_id)
            ->whereIn('colaborador_id', $colaboradores_selecionados)
            ->update(['treinamento_realizado' => 'SIM']);
            

        return redirect()->route('treinamentos.index')->with('mensagem', 'Lista de Presença atualizada com sucesso.');
        // return back()->with('mensagem', 'Lista de Presença atualizada com sucesso.');
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