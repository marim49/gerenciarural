<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('terras', 'Insumo\TerraController@index');
Route::get('maquinas', 'Maquina\MaquinaController@index');
Route::get('medicamentos', 'Animal\MedicamentoController@index');
Route::get('animal', 'Animal\AnimalController@index');
Route::get('fazendas', 'Fazenda\FazendaController@index');
Route::get('insumos', 'Insumo\InsumoController@index');
Route::get('celeiros', 'Insumo\CeleiroController@index');
Route::get('medicamentos', 'Animal\MedicamentoController@index');
Route::get('funcionarios', 'Funcionario\FuncionarioController@index');
Route::get('teste', function(){
    phpinfo();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
