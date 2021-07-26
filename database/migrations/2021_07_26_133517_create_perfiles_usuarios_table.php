<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfiles_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->string('Empresa',65);
            $table->string('Nombre',65);
            $table->string('ApPat',65);
            $table->string('ApMat',65);
            $table->string('Curp',20)->unique();
            $table->string('Rfc',20)->unique();
            $table->string('Nss',20)->unique();
            $table->string('Direccion');
            $table->string('Telefono',20);
            $table->date('Cumpleaños');
            $table->date('FecIng');
            $table->integer('Antiguedad');
            $table->integer('DiasVac');
            $table->string('Area')->nullable();
            $table->string('Departamento');
            $table->string('Puesto');
            $table->unsignedBigInteger('jefes_areas_id'); //Numero control empleado

            $table->foreign("jefes_areas_id")->references("id")->on("jefes_areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

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
        Schema::dropIfExists('perfiles_usuarios');
    }
}
