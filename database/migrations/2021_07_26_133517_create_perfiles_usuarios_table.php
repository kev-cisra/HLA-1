<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

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
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->string('Empresa',15)->nullable();
            $table->string('Nombre',35);
            $table->string('ApPat',35);
            $table->string('ApMat',35);
            $table->string('Curp')->unique()->nullable();
            $table->string('Rfc',20)->unique()->nullable();
            $table->string('Nss',20)->unique()->nullable();
            $table->string('Direccion')->nullable();
            $table->string('Telefono',20)->nullable();
            $table->date('Cumpleaños')->nullable();
            $table->date('FecIng');
            $table->integer('Antiguedad');
            $table->integer('DiasVac');

            $table->unsignedBigInteger('jefe_id')->nullable();
            $table->foreign("jefe_id")->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign("IdUser")->references("id")->on("users")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('user_id')->nullable()->unique();
            $table->foreign("user_id")->references("id")->on("users")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Puesto_id')->nullable();

            $table->foreign("Puesto_id")->references("id")->on("puestos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Departamento_id')->Nullable();

            $table->foreign("Departamento_id")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");


            $table->unsignedBigInteger('jefes_areas_id')->nullable();

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
