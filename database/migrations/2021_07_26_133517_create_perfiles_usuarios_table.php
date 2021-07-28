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
            $table->string('Empresa',15);
            $table->string('Nombre',35);
            $table->string('ApPat',35);
            $table->string('ApMat',35);
            $table->string('Curp',20)->unique();
            $table->string('Rfc',20)->unique();
            $table->string('Nss',20)->unique();
            $table->string('Direccion');
            $table->string('Telefono',20);
            $table->date('Cumpleaños');
            $table->date('FecIng');
            $table->integer('Antiguedad');
            $table->integer('DiasVac');

            $table->unsignedBigInteger('Areas_id');

            $table->foreign("Areas_id")->references("id")->on("areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Puesto_id');

            $table->foreign("Puesto_id")->references("id")->on("puestos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Departamento_id');

            $table->foreign("Departamento_id")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");


            $table->unsignedBigInteger('jefes_areas_id');

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
