<?php

//Rota animais
Route::get('/pesquisa/animal','AnimalController@GetAnimal');
//Rota para pesquisar funcionário
Route::get('/pesquisa/funcionario', 'HomeController@Teste');
//Rota para cirar animal
Route::post('/criar/animal', 'AnimalController@Create');

//Não sei o que é
Route::get('/cadastro/farmacia', function () {
    return view('cfarmacia');
});
//Rotas de início
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('welcome');
});
//Rotas para fazenda (arrumando)
Route::get('/cadastro/fazenda', function () {
    return view('cfazenda');
});
//Rotas para funcionário
Route::get('/cadastro/funcionario', function () {
    return view('cfuncionario');
});
//Rotas para máquinas e combústiveis
Route::get('/cadastro/combustivel', function () {
    return view('ccombustivel');
});
Route::get('/cadastro/maquina', function () {
    return view('cmaquina');
});
//Rotas para animais, medicamentos e relacionados..
Route::get('/cadastro/tipomedicamento', function () {
    return view('ctmedicamento');
});
Route::get('/cadastro/animal', function () {
    return view('canimal');
});
//Rotas para insumo, terra e realacionados..
Route::get('/cadastro/insumo', function () {
    return view('cinsumo');
});
Route::get('/cadastro/celeiro', function () {
    return view('cceleiro');
});
Route::get('/cadastro/terra', function () {
    return view('cterra');
});
Route::get('/cadastro/tipoinsumo', function () {
    return view('ctinsumo');
});


Auth::routes();

//testes
Route::get('/teste', function () {
    return view('teste');
});
