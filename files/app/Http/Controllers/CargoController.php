<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCargo;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cargo $cargo)
    {
        $cargos = $cargo->all();
        return view('settings/cargos/cargos', compact('cargos'));
    }


    /**
     *
     * Função que Mostra a View Edit e insere o valor nos campos do fomrulário para edição
     *
     */
    public function show(string $id)
    {
        if (!$cargo = Cargo::find($id)) {
            return back();
        }
        $cargos = $cargo->all();
        return view('settings/cargos/edit', compact('cargo', 'cargos'));
    }


    /**
     *
     * Função que salva novo registro no BD
     *
     */
    public function store(StoreUpdateCargo $request)
    {
        $data = $request->validated();

        Cargo::create($data);
        return redirect()->route('cargos.index')->with('mensagem', 'Cargo cadastrado com sucesso!');
    }


    /**
     *
     * Função que atualiza dados no BD
     *
     */
    public function update(StoreUpdateCargo $request, Cargo $cargo, string $id)
    {
        if (!$cargo = $cargo->find($id)) {
            return back()->with('mensagem', 'Erro');
        }

        $cargo->update($request->validated());
        return redirect()->route('cargos.index')->with('mensagem', 'Cargo atualizado com sucesso!');
    }


    /**
     *
     * Função que deleta registro no banco
     *
     */
    public function destroy(string|int $id)
    {
        if (!$cargo = Cargo::find($id)) {
            return back()->with('mensagem', 'Error');
        }
        $cargo->delete();
        return redirect()->route('cargos.index')->with('mensagem', 'Cargo excluido com sucesso!');
    }
}
