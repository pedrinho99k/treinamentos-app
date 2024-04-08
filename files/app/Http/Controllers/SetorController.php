<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateSetor;
use App\Models\Setor;

class SetorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Setor $setor)
    {
        $setores = $setor->all();
        return view('settings/setores/setores', compact('setores'));
    }


    /**
     *
     * Função que Mostra a View Edit e insere o valor nos campos do fomrulário para edição
     *
     */
    public function show(string|int $id)
    {
        if (!$setor = Setor::find($id)) {
            return back();
        }
        $setores = $setor->all();
        return view('settings/setores/edit', compact('setor', 'setores'));
    }


    /**
     *
     * Função que salva no BD
     *
     */
    public function store(StoreUpdateSetor $request)
    {
        $data = $request->validated();
        Setor::create($data);
        return redirect()->route('setores.index')->with('mensagem', 'Setor cadastrado com sucesso!');
    }


    /**
     *
     * Função que atualiza dados no BD
     *
     */
    public function update(StoreUpdateSetor $request, Setor $setor, string $id)
    {
        if (!$setor = $setor->find($id)) {
            return back()->with('mensagem', 'Erro');
        }

        $setor->update($request->validated());
        return redirect()->route('setores.index')->with('mensagem', 'Setor atualizado com sucesso!');
    }


    /**
     *
     * Função que deleta registro no banco
     *
     */
    public function destroy(string|int $id)
    {
        if (!$setor = Setor::find($id)) {
            return back()->with('mensagem', 'Error');
        }
        $setor->delete();
        return redirect()->route('setores.index')->with('mensagem', 'Setor excluido com sucesso!');
    }
}
