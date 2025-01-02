<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ecs', function (Blueprint $table) {
            $table->integer('credits_ects')->nullable(); // Ajoutez cette ligne
        });
    }
    
    public function down()
    {
        Schema::table('ecs', function (Blueprint $table) {
            $table->dropColumn('credits_ects');
        });
    }
    };
