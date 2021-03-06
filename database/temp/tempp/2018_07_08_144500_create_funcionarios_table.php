<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_funcionario')->unsigned();
            $table->string('nome', 100);
            $table->integer('id_estado_civil')->unsigned();
            $table->string('endereco_rua', 45);
            $table->string('endereco_numero', 45);
            $table->string('endereco_bairro', 45);  
            $table->integer('id_cidade');
            $table->string('sexo', 45);
            $table->date('nascimento');
            $table->date('admissao');
            $table->string('rg', 45);
            $table->string('cpf', 45);
            $table->string('pis', 45);
            $table->string('tel_fixo', 45);
            $table->string('celular', 45);
            $table->string('cep', 45);          
            $table->foreign('id_cidade')->references('id')->on('cidade');
            $table->foreign('id_estado_civil')->references('id')->on('estado_civil');
            $table->foreign('id_tipo_funcionario')->references('id')->on('tipo_funcionario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
