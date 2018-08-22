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
    * animais/{id} => PUT(update)
    */
    Route::resource('animal', 'Animal\AnimalController')->except(['show', 'edit', 'destroy']);
    /* ROTA: FAZENDAS
    * fazendas => POST(store), GET(index) 
    * fazendas/create => GET(create) 
    * fazendas/{id} => DELETE(destroy)
    */ 
    Route::resource('fazenda', 'Fazenda\FazendaController')->except(['edit', 'show', 'destroy']);

    /* ROTA: TERRA
    * terra => POST(store), GET(index) 
    * terra/create => GET(create) 
    * terra/{id} => PUT(update)
    */
    Route::resource('terra', 'Insumo\TerraController')->except(['edit', 'show', 'destroy']);

    /* ROTA: FUNCIONARIO
    * funcionario => POST(store), GET(index) 
    * funcionario/create => GET(create) 
    * funcionario/{id} => GET(show), PUT(update), DELETE(destroy)
    * funcionario/{id}/edit => GET(edit)
    */
    Route::resource('funcionario', 'Funcionario\FuncionarioController')->except(['edit', 'destroy', 'show']);

 
    /* ROTA: FUNCIONARIO
    * funcionario => POST(store), GET(index) 
    * funcionario/create => GET(create) 
    * funcionario/{id} => PUT(update)
    */
    Route::resource('fornecedor', 'FornecedorController')->except(['edit', 'destroy', 'show']);
   
    /* ROTA: INSUMO
    * insumo => POST(store), GET(index) 
    * insumo/create => GET(create) 
    * insumo/{id} => PUT(update)
    */
    Route::resource('insumo', 'Insumo\InsumoController')->except(['edit', 'show', 'destroy']);

    /* ROTA: TIPO INSUMO
    * tipoinsumo => POST(store), GET(index) 
    * tipoinsumo/create => GET(create) 
    * tipoinsumo/{id} => GET(show), PUT(update), DELETE(destroy)
    * tipoinsumo/{id}/edit => GET(edit)
    */
    Route::resource('tipoinsumo', 'Insumo\TipoInsumoController')->except(['show', 'update', 'edit', 'destroy', 'index']);

    /* ROTA: GRUPO ANIMAL
    * grupoanimal => POST(store), GET(index) 
    * grupoanimal/create => GET(create) 
    * grupoanimal/{id} => GET(show), PUT(update), DELETE(destroy)
    * grupoanimal/{id}/edit => GET(edit)
    */
    Route::resource('grupoanimal', 'Animal\GrupoAnimalController')->except(['show', 'update', 'edit', 'destroy', 'index']);

    /* ROTA: TIPO MEDICAMENTO
    * tipomedicamento => POST(store), GET(index) 
    * tipomedicamento/create => GET(create) 
    * tipomedicamento/{id} => GET(show), PUT(update), DELETE(destroy)
    * tipomedicamento/{id}/edit => GET(edit)
    */
    Route::resource('tipomedicamento', 'Animal\TipoMedicamentoController')->except(['show', 'update', 'edit', 'destroy', 'index']);

    /* ROTA: MEDICAMENTO
    * medicamento => POST(store), GET(index) 
    * medicamento/create => GET(create) 
    * medicamento/{id} => PUT(update)
    */
    Route::resource('medicamento', 'Animal\MedicamentoController')->except(['edit', 'show', 'destroy']);

    /* ROTA: MÁQUINA
    * maquina => POST(store), GET(index) 
    * maquina/create => GET(create) 
    * maquina/{id} => PUT(update)
    */
    Route::resource('maquina', 'Maquina\MaquinaController')->except(['edit', 'show', 'destroy']);

    /* ROTA: HISTÓRICO ABASTECIMENTO (para saída de combustível)
    * abastecimento => POST(store), GET(index) 
    * abastecimento/create => GET(create) 
    * abastecimento/{id} => DELETE(destroy)
    */
    Route::resource('abastecimento', 'Maquina\HistoricoAbastecimentoController')->except(['show', 'update', 'edit']);

    /* ROTA: HISTÓRICO ANIMAL (para saída de medicamento)
    * medicacao => POST(store), GET(index) 
    * medicacao/create => GET(create) 
    * medicacao/{id} => DELETE(destroy)
    */
    Route::resource('medicacao', 'Animal\HistoricoAnimalController')->except(['show', 'update', 'edit']);

    /* ROTA: HISTÓRICO TERRA (para saída de insumo e uso na terra)
    * plantio => POST(store), GET(index) 
    * plantio/create => GET(create) 
    * plantio/{id} => DELETE(destroy)
    */
    Route::resource('plantio', 'Insumo\HistoricoTerraController')->except(['show', 'update', 'edit']);

    /* ROTA: HISTÓRICO COMPRA COMBUSTÍVEL
    * compra-combustivel => POST(store), GET(index) 
    * compra-combustivel/create => GET(create) 
    * compra-combustivel/{id} => DELETE(destroy)
    */
    Route::resource('compra-combustivel', 'Maquina\HistoricoCompraCombustivelController')->except(['show', 'update', 'edit']);

    /* ROTA: HISTÓRICO COMPRA INSUMO
    * compra-insumo => POST(store), GET(index) 
    * compra-insumo/create => GET(create) 
    * compra-insumo/{id} => DELETE(destroy)
    */
    Route::resource('compra-insumo', 'Insumo\HistoricoCompraInsumoController')->except(['show', 'update', 'edit']);

    /* ROTA: HISTÓRICO COMPRA MEDICAMENTO
    * compra-medicamento => POST(store), GET(index) 
    * compra-medicamento/create => GET(create) 
    * compra-medicamento/{id} => DELETE(destroy)
    */
    Route::resource('compra-medicamento', 'Animal\HistoricoCompraMedicamentoController')->except(['show', 'update', 'edit']);

    /* ROTA: COMBUSTÍVEL
    * combustivel => POST(store), GET(index) 
    * combustivel/create => GET(create) 
    * combustivel/{id} => DELETE(destroy)
    */
    Route::resource('combustivel', 'Maquina\CombustivelController')->except(['show', 'update', 'destroy', 'edit']);
    
    /* ROTA: REVISÃO
    * revisao => POST(store), GET(index) 
    * revisao/create => GET(create) 
    * revisao/{id} => DELETE(destroy)
    */
    Route::resource('revisao', 'Maquina\HistoricoRevisaoController')->except(['show', 'update', 'edit']);
});