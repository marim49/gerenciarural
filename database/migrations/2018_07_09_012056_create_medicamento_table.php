<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_fazenda')->unsigned(); 
            $table->integer('id_tipo_medicamento')->unsigned(); 
            $table->float('quantidade');            
            $table->string('nome', 45);  
            $table->string('obs', 45);  
            $table->foreign('id_fazenda')->references('id')->on('fazenda');
            $table->foreign('id_tipo_medicamento')->references('id')->on('tipo_medicamento');
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
        Schema::dropIfExists('medicamento');
    }
}
