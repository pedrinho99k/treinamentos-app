<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateColaborador;
use App\Models\Cargo;
use App\Models\Colaborador;
use App\Models\Setor;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Colaborador $colaborador, Cargo $cargo, Setor $setor)
    {
        $colaboradores = $colaborador::with(['cargo', 'setor'])->get();
        $cargos = $cargo->all();
        $setores = $setor->all();

        return view('colaboradores/colaboradores', compact('colaboradores', 'cargos', 'setores'));
    }


    /**
     *
     * Função que salva novo registro no BD
     *
     */
    public function store(StoreUpdateColaborador $request)
    {

        $data = $request->validated();

        Colaborador::create($data);
        return redirect()->route('colaboradores.index')->with('mensagem', 'Colaborador(a) cadastrado com sucesso!');
    }

    /**
     *
     * Função que Mostra a View Edit e insere o valor nos campos do fomrulário para edição
     *
     */
    public function show(string $id, Cargo $cargo, Setor $setor)
    {
        if (!$colaborador = Colaborador::find($id)) {
            return back();
        }
        $colaboradores = $colaborador->all();
        $cargos = $cargo->all();
        $setores = $setor->all();
        return view('colaboradores/edit_colaboradores', compact('colaborador', 'cargos', 'setores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     *
     * Função que atualiza dados no BD
     *
     */
    public function update(StoreUpdateColaborador $request, Colaborador $colaborador, string $id)
    {
        if (!$colaborador = $colaborador->find($id)) {
            return back()->with('mensagem', 'Erro');
        }

        $colaborador->update($request->validated());
        return redirect()->route('colaboradores.index')->with('mensagem', 'Colaborador atualizado com sucesso!');
    }

    /**
     *
     * Deletar objeto
     *
     */
    public function destroy(Colaborador $colaborador, string|int $id, string $colaborador_ativo)
    {

        if (!$colaborador = $colaborador->find($id)) {
            return back()->with('mensagem', 'Erro');
        }

        switch ($colaborador_ativo) {
            case 'SIM':
                $colaborador->update(['colaborador_ativo' => 'NÃO']);
                return redirect()->route('colaboradores.index')->with('mensagem', 'Colaborador Inativado com sucesso!');
                break;
            case 'NÃO':
                $colaborador->update(['colaborador_ativo' => 'SIM']);
                return redirect()->route('colaboradores.index')->with('mensagem', 'Colaborador AtivaDO com sucesso!');
                break;
        }
    }
}
