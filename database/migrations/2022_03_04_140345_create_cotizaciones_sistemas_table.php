<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones_sistemas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->string('TipoPago',15);
            $table->string('Moneda',4)->default('MXN');
            $table->float('TipoCambio')->default(1);
            $table->tinyInteger('Aprobado')->default(0);
            $table->string('Comentario')->default('S/C');
            $table->string('Archivo')->nullable();

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
        Schema::dropIfExists('cotizaciones_sistemas');
    }
}
