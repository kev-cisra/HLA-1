<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosRequisicionesSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_requisiciones_sistemas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->integer('Cantidad');
            $table->string('Unidad',5);

            $table->unsignedBigInteger('Hardware_id');
            $table->foreign("Hardware_id")->references("id")->on("hardware_sistemas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('requisicion_sistemas_id')->nullable();
            $table->foreign("requisicion_sistemas_id")->references("id")->on("requisiciones_sistemas")
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
        Schema::dropIfExists('articulos_requisiciones_sistemas');
    }
}
