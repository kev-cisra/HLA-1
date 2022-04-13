<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->string('Nombre',65)->nullable();
            $table->date('FechaInicio');
            $table->date('FechaFin');
            $table->string('Comentarios')->nullable();
            $table->integer('Estatus')->nullable();
            $table->integer('DiasTomados');
            $table->integer('DiasRestantes');
            $table->string('MotivoCancelacion')->nullable();
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
        Schema::dropIfExists('vacaciones');
    }
}
