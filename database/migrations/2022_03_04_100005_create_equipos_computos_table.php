<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposComputosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_computos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->integer('Cantidad');
            $table->string('Nombre',35);
            $table->string('Marca',25)->nullable();
            $table->string('Modelo',45)->nullable();
            $table->string('NumeroSerie',20)->nullable();
            $table->text('Comentarios')->nullable();
            $table->integer('Estatus')->default(0);

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
        Schema::dropIfExists('equipos_computos');
    }
}
