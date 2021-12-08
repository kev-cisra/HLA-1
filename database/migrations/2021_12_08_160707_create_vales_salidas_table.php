<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValesSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vales_salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado
            $table->string('Folio',10);
            $table->date('Fecha');
            $table->string('NombreProveedor', 65)->nullable();
            $table->string('EstatusVale', 20);
            $table->date('Salida');

            $table->unsignedBigInteger('requisiciones_id');
            $table->foreign("requisiciones_id")->references("id")->on("requisiciones")
            ->onDelete("cascade")
            ->onUpdate("cascade");

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
        Schema::dropIfExists('vales_salidas');
    }
}
