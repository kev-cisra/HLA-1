<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJefesAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jefes_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Numero persona que realiza el registro
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->string('Nombre',45);
            $table->string('Area',45);
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
        Schema::dropIfExists('jefes_areas');
    }
}
