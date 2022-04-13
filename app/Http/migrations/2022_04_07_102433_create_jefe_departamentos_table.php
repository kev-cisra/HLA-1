<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJefeDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jefe_departamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session Registro en tabla

            $table->unsignedBigInteger('Perfil_id')->nullable();
            $table->foreign("Perfil_id")->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Departamento_id')->nullable();
            $table->foreign("Departamento_id")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->tinyInteger('Cargo'); //Jefe - Coordinador/Encargado - Lider

            $table->softDeletes(); //Columna para soft delete
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
        Schema::dropIfExists('jefe_departamentos');
    }
}
