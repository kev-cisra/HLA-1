<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->string('Precio')->nullable();
            $table->string('Total')->nullable();
            $table->string('Marca',45)->nullable();
            $table->string('Proveedor',65)->nullable();
            $table->string('Comentarios')->nullable();
            $table->string('Archivo')->nullable();
            $table->string('Autorizado',45)->nullable();

            $table-> unsignedBigInteger('articulos_requisiciones_id'); //Numero control empleado
            $table-> unsignedBigInteger('requisiciones_id'); //Numero control empleado

            $table->foreign("articulos_requisiciones_id")->references("id")->on("articulos_requisiciones")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign("requisiciones_id")->references("id")->on("requisiciones")
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
        Schema::dropIfExists('precios_cotizaciones');
    }
}
