<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostosEmpaquesEtiquetasTermicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costos_empaques_etiquetas_termicas', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha');
            $table->integer('NumFactura');
            $table->string('Proveedor');
            $table->string('Concepto');
            $table->string('Moneda');
            $table->double('Importe');
            $table->string('TipoCambio');
            $table->string('Conversion');
            $table->string('Rollo');
            $table->string('CostoEtiqueta');
            $table->string('KilosPorEtiqueta');
            $table->string('CostoUnitario');
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
        Schema::dropIfExists('costos_empaques_etiquetas_termicas');
    }
}
