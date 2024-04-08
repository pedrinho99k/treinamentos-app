<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProfessor;
use App\Models\Cargo;
use App\Models\Colaborador;
use App\Models\Professor;
use App\Models\Setor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Professor $professor, Colaborador $colaborador, Cargo $cargo, Setor $setor)
    {
        $professores = $professor->all();
        $colaboradores = $colaborador::with(['setor', 'cargo'])->get();
        return view('professores.professores', compact('professores', 'colaboradores'));
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
    public function store(StoreUpdateProfessor $request)
    {
        $data = $request->validated();
        Professor::create($data);
        return redirect()->route('professores.index')->with('mensagem', 'Professor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$professor = Professor::find($id)){
            return back();
        }
        $professores = $professor->all();
        return view('professores/edit_professores', compact('professor'));
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
    public function update(StoreUpdateProfessor $request, Professor $professor, string $id)
    {
        if(!$professor = $professor::find($id)){
            return back()->winth('mensagem','Erro');
        }

        $professor->update($request->validated());
        return redirect()->route('professores.index')->with('mensagem', 'Professor atualizado com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor, string|int $id, string $professor_ativo)
    {
        if (!$professor = $professor->find($id)) {
            return back()->with('mensagem', 'Error');
        }
        switch ($professor_ativo) {
            case 'SIM':
                $professor->update(['professor_ativo' => 'NÃO']);
                return redirect()->route('professores.index')->with('mensagem', 'Colaborador Inativado com sucesso!');
                break;
            case 'NÃO':
                $professor->update(['professor_ativo' => 'SIM']);
                return redirect()->route('professores.index')->with('mensagem', 'Colaborador Ativado com sucesso!');
                break;
        }
    }
}
