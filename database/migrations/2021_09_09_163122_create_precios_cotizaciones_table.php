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
            $table->string('Precio',15)->nullable();
            $table->string('Total',15)->nullable();
            $table->string('Moneda',5)->default('MXN')->nullable();
            $table->string('TipoCambio',13)->default(0)->nullable();
            $table->string('Marca',45)->nullable();
            $table->string('Proveedor',65)->nullable();
            $table->string('Comentarios')->nullable();
            $table->string('Archivo')->nullable();
            $table->text('Firma')->nullable();
            $table->string('NombreProveedor',45)->nullable();
            $table->integer('Autorizado')->default(0);

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
