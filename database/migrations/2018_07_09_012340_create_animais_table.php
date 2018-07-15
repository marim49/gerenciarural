<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_grupo_animal')->unsigned();
            $table->integer('id_fazenda')->unsigned();
            $table->string('nome', 45);
            $table->foreign('id_grupo_animal')->references('id')->on('grupo_animal');
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
        Schema::dropIfExists('animais');
    }
}
