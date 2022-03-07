<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->timestamp('FechaProgramada');
            $table->timestamp('FechaReal')->nullable();
            $table->double('Diferencia')->nullable();
            $table->string('Periodo',10);
            $table->string('Tiempo',15);
            $table->integer('Estatus')->default(0);
            $table->text('Comentarios')->nullable();

            $table->unsignedBigInteger('EquipoComputo_id');
            $table->foreign("EquipoComputo_id")->references("id")->on("equipos_computos")
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
        Schema::dropIfExists('mantenimientos');
    }
}
