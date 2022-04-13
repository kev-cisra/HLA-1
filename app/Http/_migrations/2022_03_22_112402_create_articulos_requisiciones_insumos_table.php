<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosRequisicionesInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_requisiciones_insumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->integer('Cantidad');
            $table->tinyInteger('Estatus')->default(1);

            $table->unsignedBigInteger('requisiciones_insumos_id')->nullable();
            $table->foreign("requisiciones_insumos_id")->references("id")->on("requisiciones_insumos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('insumo_id')->nullable();
            $table->foreign("insumo_id")->references("id")->on("insumos")
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
        Schema::dropIfExists('articulos_requisiciones_insumos');
    }
}
