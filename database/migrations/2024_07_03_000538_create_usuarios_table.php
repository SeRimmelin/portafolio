<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->char('nombre');
            $table->char('apellido');
            $table->char('correo');
            $table->char('telefono');
            $table->char('rut');
            $table->date('fechaN');
            $table->char('password')->unique();
            $table->decimal('peso');
            $table->decimal('altura');
            $table->decimal('imc');
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
        Schema::dropIfExists('usuarios');
    }
}
