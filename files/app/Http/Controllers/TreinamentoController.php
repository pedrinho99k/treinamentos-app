<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTreinamento;
use App\Models\Cargo;
use App\Models\MatrizTreinamento;
use App\Models\MatrizTreinamentoCargo;
use App\Models\Professor;
use App\Models\Setor;
use App\Models\Colaborador;
use App\Models\Treinamento;
use App\Models\TreinamentoRegistro;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class TreinamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Treinamento $treinamento, Setor $setor,MatrizTreinamento $m_treinamento, Professor $professor)
    {
        $treinamentos_filtro = $treinamento->where('treinamento_ativo', 'SIM')->get();
        $treinamentos = $treinamento->get();
        $m_treinamentos = $m_treinamento->where('m_treinamento_ativo', 'SIM')->get();
        $professores = $professor->where('professor_ativo','SIM')->get();
        $setores = $setor->where('setor_ativo','SIM')->get();

        return view(
            'treinamentos/treinamentos',
            compact(
                'treinamentos',
                'treinamentos_filtro',
                'm_treinamentos',
                'professores',
                'setores'
            )
        );
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
        try {
            // Inserir na tabela Treinamentos
            $criar_treinamento = Treinamento::create($request->all());

            // Pega os Cargos Marcados No Formulario
            $cargos = $request->input('cargo_id');

            DB::beginTransaction();

            $treinamento = $criar_treinamento->id;

            $cargos = explode(',' , $cargos);

            foreach ($cargos as $cargo) {
                $colaboradores = Colaborador::where('colaborador_cargo_id', $cargo)->get();

                foreach ($colaboradores as $colaborador) {

                    $registro = [
                        'treinamento_id' => $treinamento,
                        'cargo_id' => $cargo,
                        'colaborador_id' => $colaborador->id,
                        'treinamento_realizado' => 'SIM',
                        'updated_at' => $criar_treinamento->updated_at,
                        'created_at' => $criar_treinamento->created_at
                    ];

                    // Insere os registros de treinamento no banco de dados
                    TreinamentoRegistro::insert($registro);
                }
            }

            DB::commit();
            return redirect()->route('treinamentos.index')->with('mensagem', 'Treinamento criado com sucesso.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('treinamentos.index')->with('mensagem', $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id, Cargo $cargo, Setor $setor, Professor $professor, MatrizTreinamento $m_treinamento)
    {
        // Consultas no Banco de Dados
        $treinamento_id = Treinamento::where('id', $id)->pluck('treinamento_m_treinamento_id');
        $matriz_treinamento_cargos = MatrizTreinamentoCargo::where('m_treinamento_id', $treinamento_id)->get();
        $cargos_id = $matriz_treinamento_cargos->pluck('m_cargo_id')->toArray();


        // LOOP para salvar os cargos recebidos em um array
        $cargos = [];
        foreach ($cargos_id as $cargo_id) {
            $cargo = Cargo::find($cargo_id);
            $cargos[] = $cargo->toArray();
        }


        // Buscar os professores
        $professores = $professor->where('professor_ativo','SIM')->get();

        // Buscar na tabela de Treinamento
        $treinamento = Treinamento::find($id);

        // Buscar na Matriz de Treinamento
        $matriz_treinamento = MatrizTreinamento::find($treinamento->treinamento_m_treinamento_id);
        $descricao = strlen($matriz_treinamento->m_treinamento_descricao) > 50 ? substr($matriz_treinamento->m_treinamento_descricao, 0, 50) . '...' : $matriz_treinamento->m_treinamento_descricao;

        // Buscar no Registro de Treinamentos
        $treinamento_registro = TreinamentoRegistro::where('treinamento_id', $id)->pluck('cargo_id')->toArray();

        // Buscar os setores
        $setores = $setor->all();

        return view(
            'treinamentos/edit_treinamentos',

            compact(
                'cargos',
                'setores',
                'treinamento',
                'professores',
                'descricao',
                'treinamento_registro'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Recupere o registro que deseja atualizar
        $treinamento = Treinamento::findOrFail($id);

        // Cargos selecionados na checkbox
        $cargosSelecionados = $request->m_treinamento_cargos;

        if (empty($cargosSelecionados)) {
            return back()->with('error', 'Selecione um cargo');
        }

        $dataAtual = Carbon::now();

        $treinamento->update([
            'treinamento_setor_responsavel_id' => $request->treinamento_setor_responsavel_id,
            'treinamento_professor_id' => $request->treinamento_professor_id,
            'treinamento_data' => $request->treinamento_data,
            'treinamento_tempo' => $request->treinamento_tempo,
            'updated_at' => $cargosSelecionados,
            // 'treinamento_obrigatorio' => $request->treinamento_obrigatorio,
            // 'treinamento_obrigatorio_avaliacao_eficacia' => $request->treinamento_obrigatorio_avaliacao_eficacia,
            // 'treinamento_ativo' => $request->treinamento_ativo,
        ]);

        // Remova todos os relacionamentos existentes
        TreinamentoRegistro::where('treinamento_id', $id)->delete();

        DB::beginTransaction();

            // Loop dos cargos
            foreach ($cargosSelecionados as $cargo) {
                $colaboradores = Colaborador::where('colaborador_cargo_id', $cargo)->get();

                foreach ($colaboradores as $colaborador) {

                    $registro = [
                        'treinamento_id' => $id,
                        'cargo_id' => $cargo,
                        'colaborador_id' => $colaborador->id,
                        'treinamento_realizado' => 'SIM',
                        'updated_at' => $dataAtual,
                        'created_at' => $dataAtual
                    ];

                    // Insere os registros de treinamento no banco de dados
                    TreinamentoRegistro::insert($registro);
                }
            }

            // Adicione os novos relacionamentos
            $cargosSelecionados = $request->input('treinamento_cargos', []);
            foreach ($cargosSelecionados as $cargoId) {
                $treinamento->cargos()->create(['cargo_id' => $cargoId]);
            }

        DB::commit();
        return redirect()->route('treinamentos.index')->with('mensagem', 'Treinamento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            // Encontrar o treinamento usando ID
            $treinamento = Treinamento::findOrFail($id);

            // Verificar se está ativo
            if ($treinamento->treinamento_ativo === 'NÃO') {
                $treinamento->treinamento_ativo = 'SIM';
                $treinamento->save();

                DB::commit();
                return redirect()->route('treinamentos.index')->with('mensagem', 'Treinamento Ativado');
            } else {
                $treinamento->treinamento_ativo = 'NÃO';
                $treinamento->save();

                DB::commit();
                return redirect()->route('treinamentos.index')->with('mensagem', 'Treinamento Desativado');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('treinamentos.index')->with('mensagem', 'Erro ao Desativar' . $e->getMessage());
        }
    }

    public function buscarMatrizCargo(Request $request, string $id)
    {
        // Recebe o matriz_id do ajax da pagina blade
        $id = $request->input('matriz_id');

        // Realizar a consulta no banco de dados e retorna o id dos cargos
        $matrizTreinamentosCargos = MatrizTreinamentoCargo::where('m_treinamento_id', $id)
            ->get();

        $id_cargos = $matrizTreinamentosCargos->pluck('m_cargo_id')->toArray();

        $matrizCargosDescricao = Cargo::whereIn('id',$id_cargos)
            ->get();
            

        return response()->json($matrizCargosDescricao);
    }

    public function filtro(Request $request)
    {
        dd($request);
    }

}