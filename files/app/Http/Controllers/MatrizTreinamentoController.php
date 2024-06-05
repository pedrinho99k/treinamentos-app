<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateMatrizTreinamento;
use App\Models\Cargo;
use App\Models\MatrizTreinamento;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatrizTreinamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MatrizTreinamento $matriz_treinamento, Setor $setor, Cargo $cargo, Request $request)
    {
        $query = MatrizTreinamento::query();

        if ($request->filled('identificador')) {
            $query->where('id', 'like', '%' . $request->identificador . '%');
        }

        if ($request->filled('descricao')) {
            $query->where('m_treinamento_descricao', 'like', '%' . $request->descricao . '%');
        }

        if ($request->filled('setor')) {
            $setorDescricao = $request->setor;
            $query->whereHas('setor', function ($q) use ($setorDescricao) {
                $q->where('setor_descricao', 'like', '%' . $setorDescricao . '%');
            });
        }

        if ($request->filled('cargo')) {
            $cargoDescricao = $request->cargo;
            $query->whereHas('cargos.cargo', function ($q) use ($cargoDescricao) {
                $q->where('cargo_descricao', 'like', '%' . $cargoDescricao . '%');
            });
        }

        $matriz_treinamentos = $query->with('cargos')->paginate(20);
        // $setores = $setor->all();
        $setores = $setor->where('setor_ativo', 'SIM')->get();
        $cargos = $cargo->where('cargo_ativo', 'SIM')->get();
        return view('matriz_treinamentos/matriz_treinamentos', compact('matriz_treinamentos', 'setores', 'cargos'));
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
    public function store(StoreUpdateMatrizTreinamento $request)
    {

        // Valide os outros campos do formulário
        //$data = $request->validated();
        // Criar a matriz de treinamentos
        $matrizTreinamento = MatrizTreinamento::create([
            'm_treinamento_descricao' => $request->m_treinamento_descricao,
            'm_treinamento_tempo' => $request->m_treinamento_tempo,
            'm_treinamento_obrigatorio' => $request->m_treinamento_obrigatorio,
            'm_treinamento_obrigatorio_avaliacao_eficacia' => $request->m_treinamento_obrigatorio_avaliacao_eficacia,
            'm_treinamento_setor_responsavel_id' => $request->m_treinamento_setor_responsavel_id,
            'm_treinamento_ativo' => $request->m_treinamento_ativo,
        ]);

        $cargosSelecionados = $request->input('m_treinamento_cargos', []);

        // Associar os setores selecionados à matriz de treinamentos
        foreach ($cargosSelecionados as $cargoId) {
            DB::table('matriz_treinamentos_cargos')->insert([
                'm_treinamento_id' => $matrizTreinamento->id,
                'm_cargo_id' => $cargoId,
            ]);
        }

        return redirect()->route('matriz_treinamentos.index')->with('mensagem', 'Matriz de Treinamento criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Cargo $cargo, Setor $setor)
    {
        $matriz_treinamento = MatrizTreinamento::find($id);
        if (!$matriz_treinamento) {
            return back()->with('error', 'Matriz de treinamento não encontrada.');
        }

        $cargos = $cargo->all();
        $setores = $setor->all();

        return view('matriz_treinamentos/edit_matriz_treinamentos', compact('matriz_treinamento', 'cargos', 'setores'));
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
        // Encontre a matriz de treinamento que está sendo atualizada
        $matrizTreinamento = MatrizTreinamento::findOrFail($id);

        // Valide os dados recebidos do formulário
        $request->validate([
            'm_treinamento_descricao' => 'required|string|max:255',
            'm_treinamento_tempo' => 'required|string|max:8', // Ajuste para atender ao seu formato de entrada de tempo
            'm_treinamento_setor_responsavel_id' => 'required|exists:setores,id',
        ]);

        $matrizTreinamento->update([
            'm_treinamento_descricao' => $request->m_treinamento_descricao,
            'm_treinamento_tempo' => $request->m_treinamento_tempo,
            'm_treinamento_obrigatorio' => $request->m_treinamento_obrigatorio,
            'm_treinamento_obrigatorio_avaliacao_eficacia' => $request->m_treinamento_obrigatorio_avaliacao_eficacia,
            'm_treinamento_setor_responsavel_id' => $request->m_treinamento_setor_responsavel_id,
            'm_treinamento_ativo' => $request->m_treinamento_ativo,
        ]);

        // Remova todos os relacionamentos existentes
        $matrizTreinamento->cargos()->delete();

        // Adicione os novos relacionamentos
        $cargosSelecionados = $request->input('m_treinamento_cargos', []);
        foreach ($cargosSelecionados as $cargoId) {
            $matrizTreinamento->cargos()->create(['m_cargo_id' => $cargoId]);
        }

        // Redirecione de volta à página de detalhes da matriz de treinamento atualizada
        return redirect()->route('matriz_treinamentos.index')->with('mensagem', 'Matriz de treinamento atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function buscarMatriz(Request $request)
    {
        $setorId = $request->input('setor_id');

        // Realize a consulta no banco de dados para obter a matriz de treinamentos
        $matrizTreinamentos = MatrizTreinamento::where('m_treinamento_setor_responsavel_id', $setorId)
            ->where('m_treinamento_ativo','SIM')
            ->get();

        return response()->json($matrizTreinamentos);
    }
    
    public function buscarMatrizId(Request $request)
    {
        $matrizId = $request->input('matriz_id');

        // Realize a consulta no banco de dados para obter a matriz de treinamentos
        $matrizTreinamentos = MatrizTreinamento::where('id', $matrizId)
            ->get();

        return response()->json($matrizTreinamentos);
    }

}
