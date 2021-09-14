<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_requisiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->date('Fecha'); //fecha de solicitud
            $table->integer('Cantidad');
            $table->string('Unidad',10);
            $table->string('Descripcion')->nullable();
            $table->integer('EstatusArt')->nullable();
            $table->string('MotivoCancelacion')->nullable();
            $table->integer('Resguardo')->default(1)->nullable();

            $table->unsignedBigInteger('requisicion_id');

            $table->foreign("requisicion_id")->references("id")->on("requisiciones")
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
        Schema::dropIfExists('articulos_requisiciones');
    }
}
