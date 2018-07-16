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

/* ROTA: INSUMO
 * insumo => POST(store), GET(index) 
 * insumo/create => GET(create) 
 * insumo/{id} => GET(show), PUT(update), DELETE(destroy)
 * insumo/{id}/edit => GET(edit)
*/
Route::resource('insumo', 'Insumo\InsumoController')/*->middleware('auth')*/;

/* ROTA: TIPO INSUMO
 * tipoinsumo => POST(store), GET(index) 
 * tipoinsumo/create => GET(create) 
 * tipoinsumo/{id} => GET(show), PUT(update), DELETE(destroy)
 * tipoinsumo/{id}/edit => GET(edit)
*/
Route::resource('tipoinsumo', 'Insumo\TipoInsumoController')/*->middleware('auth')*/;

/* ROTA: TIPO MEDICAMENTO
 * tipomedicamento => POST(store), GET(index) 
 * tipomedicamento/create => GET(create) 
 * tipomedicamento/{id} => GET(show), PUT(update), DELETE(destroy)
 * tipomedicamento/{id}/edit => GET(edit)
*/
Route::resource('tipomedicamento', 'Animal\TipoMedicamentoController')/*->middleware('auth')*/;

/* ROTA: MEDICAMENTO
 * medicamento => POST(store), GET(index) 
 * medicamento/create => GET(create) 
 * medicamento/{id} => GET(show), PUT(update), DELETE(destroy)
 * medicamento/{id}/edit => GET(edit)
*/
Route::resource('medicamento', 'Animal\MedicamentoController')/*->middleware('auth')*/;

/* ROTA: MÁQUINA
 * maquina => POST(store), GET(index) 
 * maquina/create => GET(create) 
 * maquina/{id} => GET(show), PUT(update), DELETE(destroy)
 * maquina/{id}/edit => GET(edit)
*/
Route::resource('maquina', 'Maquina\MaquinaController')/*->middleware('auth')*/;

/* ROTA: HISTÓRICO ABASTECIMENTO (para saída de combustível)
 * abastecimento => POST(store), GET(index) 
 * abastecimento/create => GET(create) 
 * abastecimento/{id} => GET(show), PUT(update), DELETE(destroy)
 * abastecimento/{id}/edit => GET(edit)
*/
Route::resource('abastecimento', 'Maquina\HistoricoAbastecimentoController')/*->middleware('auth')*/;

/* ROTA: HISTÓRICO COMPRA COMBUSTÍVEL
 * compra/combustivel => POST(store), GET(index) 
 * compra/combustivel/create => GET(create) 
 * compra/combustivel/{id} => GET(show), PUT(update), DELETE(destroy)
 * compra/combustivel/{id}/edit => GET(edit)
*/
Route::resource('compra-combustivel', 'Maquina\HistoricoCompraCombustivelController')/*->middleware('auth')*/;

/* ROTA: COMBUSTÍVEL
 * combustivel => POST(store), GET(index) 
 * combustivel/create => GET(create) 
 * combustivel/{id} => GET(show), PUT(update), DELETE(destroy)
 * combustivel/{id}/edit => GET(edit)
*/
Route::resource('combustivel', 'Maquina\CombustivelController')/*->middleware('auth')*/;

/* ROTA: TIPO COMBUSTÍVEL
 * tipocombustivel => POST(store), GET(index) 
 * tipocombustivel/create => GET(create) 
 * tipocombustivel/{id} => GET(show), PUT(update), DELETE(destroy)
 * tipocombustivel/{id}/edit => GET(edit)
*/
Route::resource('tipocombustivel', 'Maquina\TipoCombustivelController')/*->middleware('auth')*/;






//ACIMA ESTÀ CERTO
Route::get('/pesquisa/animal','AnimalController@GetAnimal');

//Rotas de início
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('welcome');
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
