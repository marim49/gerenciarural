<?php

/* ROTA: ANIMAIS
 * animais => POST(store), GET(index) 
 * animais/create => GET(create) 
 * animais/{id} => GET(show), PUT(update), DELETE(destroy)
 * animais/{id}/edit => GET(edit)
*/
Route::resource('animal', 'Animal\AnimalController')/*->middleware('auth')*/;

/* ROTA: FAZENDAS
 * fazendas => POST(store), GET(index) 
 * fazendas/create => GET(create) 
 * fazendas/{id} => GET(show), PUT(update), DELETE(destroy)
 * fazendas/{id}/edit => GET(edit)
*/
Route::resource('fazenda', 'Fazenda\FazendaController')/*->middleware('auth')*/;

/* ROTA: TERRA
 * terra => POST(store), GET(index) 
 * terra/create => GET(create) 
 * terra/{id} => GET(show), PUT(update), DELETE(destroy)
 * terra/{id}/edit => GET(edit)
*/
Route::resource('terra', 'Insumo\TerraController')/*->middleware('auth')*/;

/* ROTA: CELEIRO
 * celeiro => POST(store), GET(index) 
 * celeiro/create => GET(create) 
 * celeiro/{id} => GET(show), PUT(update), DELETE(destroy)
 * celeiro/{id}/edit => GET(edit)
*/
Route::resource('celeiro', 'Insumo\CeleiroController')/*->middleware('auth')*/;

/* ROTA: FUNCIONARIO
 * funcionario => POST(store), GET(index) 
 * funcionario/create => GET(create) 
 * funcionario/{id} => GET(show), PUT(update), DELETE(destroy)
 * funcionario/{id}/edit => GET(edit)
*/
Route::resource('funcionario', 'Funcionario\FuncionarioController')/*->middleware('auth')*/;



//ACIMA ESTÀ CERTO
Route::get('/pesquisa/animal','AnimalController@GetAnimal');

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
//Rotas para insumo, terra e realacionados..
Route::get('/cadastro/insumo', function () {
    return view('cinsumo');
});
Route::get('/cadastro/tipoinsumo', function () {
    return view('ctinsumo');
});
Route::get('/saida/combustivel', function () {
    return view('scombustivel');
});
Route::get('/entrada/combustivel', function () {
    return view('ecombustivel');
});
Route::get('/entrada/farmacia', function () {
    return view('efarmacia');
});
Route::get('/saida/farmacia', function () {
    return view('sfarmacia');
});
Route::get('/entrada/terra', function () {
    return view('eterra');
});
Route::get('/saida/terra', function () {
    return view('sterra');
});


Auth::routes();

//testes
Route::get('/teste', function () {
    return view('teste');
});
