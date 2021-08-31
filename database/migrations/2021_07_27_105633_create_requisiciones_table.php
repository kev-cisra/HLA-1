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
            $table->integer('Folio')->unique();
            $table->date('Fecha'); //fecha de solicitud
            $table->integer('NumReq');
            $table->integer('Departamento');
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
            $table->integer('Estatus')->nullable();
            $table->integer('OrdenCompra')->default(0);
            $table->text('MotivoCancelacion')->nullable();

            $table->unsignedBigInteger('Perfil_id')->nullable();

            $table->foreign("Perfil_id")->references("id")->on("perfiles_usuarios")
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
        Schema::dropIfExists('requisiciones');
    }
}
