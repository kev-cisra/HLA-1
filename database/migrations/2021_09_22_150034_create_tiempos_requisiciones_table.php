<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiemposRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiempos_requisiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado

            $table->dateTime('Solicitado')->nullable();
            $table->dateTime('Revision')->nullable();
            $table->dateTime('Cotizado')->nullable();
            $table->dateTime('Autorizado')->nullable();
            $table->dateTime('Confirmado')->nullable();
            $table->dateTime('Almacen')->nullable();
            $table->dateTime('Entregado')->nullable();

            $table->unsignedBigInteger('requisicion_id');

            $table->foreign("requisicion_id")->references("id")->on("requisiciones")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('articulo_requisicion_id');

            $table->foreign("articulo_requisicion_id")->references("id")->on("articulos_requisiciones")
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
        Schema::dropIfExists('tiempos_requisiciones');
    }
}
