<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->date('Fecha')->nullable();
            $table->integer('Folio')->unique();
            $table->integer('NumReq')->nullable();
            $table->integer('OrdenCompra')->nullable();
            $table->unsignedBigInteger('Departamento_id')->Nullable();

            $table->foreign("Departamento_id")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('jefes_areas_id')->nullable();

            $table->foreign("jefes_areas_id")->references("id")->on("jefes_areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->string('Codigo',45);

            $table->unsignedBigInteger('Maquina_id')->nullable();

            $table->foreign("Maquina_id")->references("id")->on("maquinas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Marca_id')->nullable();

            $table->foreign("Marca_id")->references("id")->on("marcas_maquinas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->string('TipCompra',45);
            $table->string('Observaciones')->nullable();

            $table->unsignedBigInteger('Perfil_id')->nullable();

            $table->foreign("Perfil_id")->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->integer('Estatus')->nullable();

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
        Schema::dropIfExists('requisiciones');
    }
}
