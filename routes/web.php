<?php

//Rotas de início
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Rotas autenticadas
Route::group(['middleware' => 'auth'], function()
{
    /* ROTA: ANIMAIS
    * animais => POST(store), GET(index) 
    * animais/create => GET(create) 
    * animais/{id} => GET(show), PUT(update), DELETE(destroy)
    * animais/{id}/edit => GET(edit)
    */
    Route::resource('animal', 'Animal\AnimalController');
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

    /* ROTA: FUNCIONARIO
    * funcionario => POST(store), GET(index) 
    * funcionario/create => GET(create) 
    * funcionario/{id} => GET(show), PUT(update), DELETE(destroy)
    * funcionario/{id}/edit => GET(edit)
    */
    Route::resource('funcionario', 'Funcionario\FuncionarioController')/*->middleware('auth')*/;

 
    /* ROTA: FUNCIONARIO
    * funcionario => POST(store), GET(index) 
    * funcionario/create => GET(create) 
    * funcionario/{id} => GET(show), PUT(update), DELETE(destroy)
    * funcionario/{id}/edit => GET(edit)
    */
    Route::resource('fornecedor', 'FornecedorController')/*->middleware('auth')*/;
   
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

    /* ROTA: GRUPO ANIMAL
    * grupoanimal => POST(store), GET(index) 
    * grupoanimal/create => GET(create) 
    * grupoanimal/{id} => GET(show), PUT(update), DELETE(destroy)
    * grupoanimal/{id}/edit => GET(edit)
    */
    Route::resource('grupoanimal', 'Animal\GrupoAnimalController')/*->middleware('auth')*/;

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

    /* ROTA: HISTÓRICO ANIMAL (para saída de medicamento)
    * medicacao => POST(store), GET(index) 
    * medicacao/create => GET(create) 
    * medicacao/{id} => GET(show), PUT(update), DELETE(destroy)
    * medicacao/{id}/edit => GET(edit)
    */
    Route::resource('medicacao', 'Animal\HistoricoAnimalController')/*->middleware('auth')*/;

    /* ROTA: HISTÓRICO TERRA (para saída de insumo e uso na terra)
    * plantio => POST(store), GET(index) 
    * plantio/create => GET(create) 
    * plantio/{id} => GET(show), PUT(update), DELETE(destroy)
    * plantio/{id}/edit => GET(edit)
    */
    Route::resource('plantio', 'Insumo\HistoricoTerraController')/*->middleware('auth')*/;

    /* ROTA: HISTÓRICO COMPRA COMBUSTÍVEL
    * compra-combustivel => POST(store), GET(index) 
    * compra-combustivel/create => GET(create) 
    * compra-combustivel/{id} => GET(show), PUT(update), DELETE(destroy)
    * compra-combustivel/{id}/edit => GET(edit)
    */
    Route::resource('compra-combustivel', 'Maquina\HistoricoCompraCombustivelController')/*->middleware('auth')*/;

    /* ROTA: HISTÓRICO COMPRA INSUMO
    * compra-insumo => POST(store), GET(index) 
    * compra-insumo/create => GET(create) 
    * compra-insumo/{id} => GET(show), PUT(update), DELETE(destroy)
    * compra-insumo/{id}/edit => GET(edit)
    */
    Route::resource('compra-insumo', 'Insumo\HistoricoCompraInsumoController')/*->middleware('auth')*/;

    /* ROTA: HISTÓRICO COMPRA MEDICAMENTO
    * compra-medicamento => POST(store), GET(index) 
    * compra-medicamento/create => GET(create) 
    * compra-medicamento/{id} => GET(show), PUT(update), DELETE(destroy)
    * compra-medicamento/{id}/edit => GET(edit)
    */
    Route::resource('compra-medicamento', 'Animal\HistoricoCompraMedicamentoController')/*->middleware('auth')*/;

    /* ROTA: COMBUSTÍVEL
    * combustivel => POST(store), GET(index) 
    * combustivel/create => GET(create) 
    * combustivel/{id} => GET(show), PUT(update), DELETE(destroy)
    * combustivel/{id}/edit => GET(edit)
    */
    Route::resource('combustivel', 'Maquina\CombustivelController')/*->middleware('auth')*/;
    
    /* ROTA: REVISÃO
    * revisao => POST(store), GET(index) 
    * revisao/create => GET(create) 
    * revisao/{id} => GET(show), PUT(update), DELETE(destroy)
    * revisao/{id}/edit => GET(edit)
    */
    Route::resource('revisao', 'Maquina\RevisaoController')/*->middleware('auth')*/;
});