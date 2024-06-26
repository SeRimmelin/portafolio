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
        Schema::create('rutinas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('series')->nullable();
            $table->integer('repeticiones')->nullable();
            $table->string('descripción')->nullable();
            $table->time('duración')->nullable();
            $table->char('categoria')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
};
