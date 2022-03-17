<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosCotizacionesSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios_cotizaciones_sistemas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->string('Marca',35);
            $table->float('Precio',10,2);
            $table->float('Total',10,2);

            $table->unsignedBigInteger('cotizacion_sistemas_id')->nullable();
            $table->foreign("cotizacion_sistemas_id")->references("id")->on("cotizaciones_sistemas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('art_req_sistemas_id')->nullable();
            $table->foreign("art_req_sistemas_id")->references("id")->on("articulos_requisiciones_sistemas")
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
        Schema::dropIfExists('precios_cotizaciones_sistemas');
    }
}
