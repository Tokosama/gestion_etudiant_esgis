<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUesTable extends Migration
{
    public function up()
    {
        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nom');
            $table->integer('credits_ects')->unsigned()->checkBetween(1, 30);
            $table->integer('semestre')->unsigned()->checkBetween(1, 6);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ues');
    }
}
