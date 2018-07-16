<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCeleiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celeiro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_fazenda')->unsigned()->unique(); 
            $table->string('nome', 45);
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
        Schema::dropIfExists('celeiro');
    }
}
