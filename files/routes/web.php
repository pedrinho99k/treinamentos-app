<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListaPresencaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\MatrizTreinamentoController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TreinamentoController;
use App\Http\Controllers\TreinamentoPresencaController;
use App\Http\Controllers\TreinamentoRegistroController;
use App\Models\Treinamento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () { // Rotas que requerem autenticação

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/settings/', [SettingsController::class, 'index'])->name('settings');

    Route::post('/settings', [SettingsController::class, 'index'])->name('settings');

    //Rotas Setores
    Route::delete('/settings/setores/{id}', [SetorController::class, 'inativar'])->name('setores.inativar');
    Route::delete('/settings/setores/{id}', [SetorController::class, 'ativar'])->name('setores.ativar');
    Route::delete('/settings/setores/{id}', [SetorController::class, 'destroy'])->name('setores.destroy');
    Route::put('/settings/setores/{id}', [SetorController::class, 'update'])->name('setores.update');
    Route::get('/settings/setores/{id}/edit', [SetorController::class, 'edit'])->name('setores.edit');
    Route::get('/settings/setores/{id}', [SetorController::class, 'show'])->name('setores.show');
    Route::post('/settings/setores', [SetorController::class, 'store'])->name('setores.store');
    Route::get('/settings/setores/edit', [SetorController::class, 'edit'])->name('setores.edit');
    Route::get('/settings/setores', [SetorController::class, 'index'])->name('setores.index');

    //Rotas Cargos
    Route::put('/settings/cargos/{id}', [CargoController::class, 'inativar'])->name('cargos.inativar');
    Route::put('/settings/cargos/{id}', [CargoController::class, 'ativar'])->name('cargos.ativar');
    Route::delete('/settings/cargos/{id}', [CargoController::class, 'destroy'])->name('cargos.destroy');
    Route::put('/settings/cargos/{id}', [CargoController::class, 'update'])->name('cargos.update');
    Route::get('/settings/cargos/{id}/edit', [CargoController::class, 'edit'])->name('cargos.edit');
    Route::get('/settings/cargos/{id}', [CargoController::class, 'show'])->name('cargos.show');
    Route::post('/settings/cargos', [CargoController::class, 'store'])->name('cargos.store');
    Route::get('/settings/cargos/edit', [CargoController::class, 'edit'])->name('cargos.edit');
    Route::get('/settings/cargos', [CargoController::class, 'index'])->name('cargos.index');

    //Rotas Colaboradores
    Route::delete('/colaboradores/{id}/{colaborador_ativo}', [ColaboradorController::class, 'destroy'])->name('colaboradores.destroy');
    Route::put('/colaboradores/{id}', [ColaboradorController::class, 'update'])->name('colaboradores.update');
    Route::get('/colaboradores/{id}/edit', [ColaboradorController::class, 'edit'])->name('colaboradores.edit');
    Route::get('/colaboradores/{id}', [ColaboradorController::class, 'show'])->name('colaboradores.show');
    Route::post('/colaboradores', [ColaboradorController::class, 'store'])->name('colaboradores.store');
    Route::get('/colaboradores/edit', [ColaboradorController::class, 'edit'])->name('colaboradores.edit');
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores.index');


    //Rotas Professores
    Route::delete('/professores/{id}/{professor_ativo}', [ProfessorController::class, 'destroy'])->name('professores.destroy');
    Route::put('/professores/{id}', [ProfessorController::class, 'update'])->name('professores.update');
    Route::get('/professores/{id}/edit', [ProfessorController::class, 'edit'])->name('professores.edit');
    Route::get('/professores/{id}', [ProfessorController::class, 'show'])->name('professores.show');
    Route::post('/professores', [ProfessorController::class, 'store'])->name('professores.store');
    Route::get('/professores/edit', [ProfessorController::class, 'edit'])->name('professores.edit');
    Route::get('/professores', [ProfessorController::class, 'index'])->name('professores.index');


    //Rotas MAtriz de treinamentos
    Route::delete('/matriz-de-treinamentos/{id}/{matriz_treinamento_ativo}', [MatrizTreinamentoController::class, 'destroy'])->name('matriz_treinamentos.destroy');
    Route::put('/matriz-de-treinamentos/{id}', [MatrizTreinamentoController::class, 'update'])->name('matriz_treinamentos.update');
    Route::get('/matriz-de-treinamentos/{id}/edit', [MatrizTreinamentoController::class, 'edit'])->name('matriz_treinamentos.edit');
    Route::get('/matriz-de-treinamentos/{id}', [MatrizTreinamentoController::class, 'show'])->name('matriz_treinamentos.show');
    Route::post('/matriz-de-treinamentos', [MatrizTreinamentoController::class, 'store'])->name('matriz_treinamentos.store');
    Route::get('/matriz-de-treinamentos/edit', [MatrizTreinamentoController::class, 'edit'])->name('matriz_treinamentos.edit');
    Route::get('/matriz-de-treinamentos', [MatrizTreinamentoController::class, 'index'])->name('matriz_treinamentos.index');
    Route::get('/buscar-matriz', [MatrizTreinamentoController::class, 'buscarMatriz'])->name('buscar_matriz');
    Route::get('/buscar-matriz-id', [MatrizTreinamentoController::class, 'buscarMatrizId'])->name('buscar_matriz_id');

    //Rotas de Registro de treinamentos
    Route::get('/buscar-matriz-cargo', [TreinamentoRegistroController::class, 'buscarMatrizCargo'])->name('buscar_matriz_cargo');

    //Rotas treinamentos
    Route::delete('/treinamentos/{id}/{treinamento_ativo}', [TreinamentoController::class, 'destroy'])->name('treinamentos.destroy');
    Route::put('/treinamentos/{id}', [TreinamentoController::class, 'update'])->name('treinamentos.update');
    Route::get('/treinamentos/{id}/edit', [TreinamentoController::class, 'edit'])->name('treinamentos.edit');
    Route::get('/treinamentos/{id}', [TreinamentoController::class, 'show'])->name('treinamentos.show');
    Route::get('/treinamentos/edit', [TreinamentoController::class, 'edit'])->name('treinamentos.edit');
    Route::match(['GET','POST'], '/treinamentos', [TreinamentoController::class, 'index'])->name('treinamentos.index');
    Route::post('/treinamentos-store', [TreinamentoController::class, 'store'])->name('treinamentos.store');
    Route::match(['POST','GET'], '/filtro-desativado', [TreinamentoController::class, 'filtro'])->name('treinamentos.filtro');

    //Rotas Lista de pressença
    Route::get('/buscar-lista-presenca',[ListaPresencaController::class, 'ListaColaboradoresTreinamento'])->name('lista_colaboradores_treinamento');
    Route::get('/lista-presenca/{treinamento_id}',[ListaPresencaController::class, 'index'])->name('lista_presenca.index');
    Route::post('/lista-presenca',[ListaPresencaController::class, 'store'])->name('lista_presenca.store');

    //Rotas Presença Treinamentos
    Route::get('/treinamento-presenca/{treinamento_id}', [TreinamentoPresencaController::class, 'index'])->name('treinamento_presenca.index');
    Route::post('/atualizar-presenca', [TreinamentoPresencaController::class, 'update'])->name('treinamento_presenca.update');
});