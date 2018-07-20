<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_fazenda')->unsigned(); 
            $table->integer('id_tipo_insumo')->unsigned(); 
            $table->string('nome', 45); 
            $table->integer('quantidade')->default(0);    
            $table->foreign('id_fazenda')->references('id')->on('fazenda');
            $table->foreign('id_tipo_insumo')->references('id')->on('tipo_insumo');
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
        Schema::dropIfExists('insumo');
    }
}
