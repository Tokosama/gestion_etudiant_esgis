<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcsTable extends Migration
{
    public function up()
    {
        Schema::create('ecs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nom');
            $table->integer('coefficient')->unsigned()->checkBetween(1, 5);
            $table->foreignId('ue_id')->constrained('ues')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ecs');
    }
}
