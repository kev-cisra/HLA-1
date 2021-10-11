<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostosEmpaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costos_empaques', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha');
            $table->date('Material');
            $table->string('Proveedor', 65);
            $table->string('Concepto',85);
            $table->string('Importe',10);
            $table->string('Moneda',5);
            $table->string('TipoCambio',10);
            $table->string('Total',10);
            $table->string('Piezas',10);
            $table->string('CostoUnitario',10);
            $table->string('CostoGramos',10);
            $table->string('CostoKilos',10);
            $table->string('CostoTotal',10);
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
        Schema::dropIfExists('costos_empaques');
    }
}
