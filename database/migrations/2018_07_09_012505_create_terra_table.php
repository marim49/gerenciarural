<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_fazenda')->unsigned();        
            $table->string('nome', 45);  
            $table->string('area', 45)->nullable(); 
            $table->foreign('id_fazenda')->references('id')->on('fazenda');
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
        Schema::dropIfExists('terra');
    }
}
