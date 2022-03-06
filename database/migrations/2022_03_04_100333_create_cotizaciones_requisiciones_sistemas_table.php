<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesRequisicionesSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones_requisiciones_sistemas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->float('Precio');
            $table->string('Marca',35);
            $table->float('Total');
            $table->String('TipoPago');
            $table->integer('Aprovado')->default(0);

            $table->unsignedBigInteger('articulo_requisicion_sistemas_id')->nullable();
            $table->foreign("articulo_requisicion_sistemas_id")->references("id")->on("articulos_requisiciones_sistemas")
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
        Schema::dropIfExists('cotizaciones_requisiciones_sistemas');
    }
}
