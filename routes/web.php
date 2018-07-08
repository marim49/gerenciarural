<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Rota para retornar os animais
Route::get('/pesquisa/animal','AnimalController@GetAnimal');
//Rota para pesquisar funcionário
Route::get('/pesquisa/funcionario', 'HomeController@Teste');
//Rota para cirar animal
Route::post('/criar/animal', 'AnimalController@Create');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/teste', function () {
    return view('teste');
});
Route::get('/cadastro/funcionario', function () {
    return view('cfuncionario');
});
Route::get('/cadastro/animal', function () {
    return view('canimal');
});
Route::get('/cadastro/combustivel', function () {
    return view('ccombustivel');
});
Route::get('/cadastro/farmacia', function () {
    return view('cfarmacia');
});
Route::get('/cadastro/fazenda', function () {
    return view('cfazenda');
});
Route::get('/cadastro/insumo', function () {
    return view('cinsumo');
});
Route::get('/cadastro/maquina', function () {
    return view('cmaquina');
});

//mas assim, agr vou ter q tratar as coisas q ela me retornar, so q isso so posso fazer se ja tiver cm os
// "bancos" no migration ne ? sim, não entedi muito bem mas sim kkk
// vc importou o "users" , ele é um treco do banco, vc conseguiu manipular os dados so pq vc fez o migration dele
// teria cm eu manipular esses dados sem ter dados migration ? tipo COm  mtiagbraetlas ja existentes no banco ?
////Thais: O migrate é só para criar as tabelas, o que vc precisa para manipular as tabelas são delas kkk
// e ddo model saca:
// Route::get('/pesquisa/funcionario', function () {
//     return view('pfuncionario');
// });

Auth::routes();
//
Route::get('/home', 'HomeController@index')->name('home');
