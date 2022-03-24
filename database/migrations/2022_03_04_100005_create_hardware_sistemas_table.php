<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_sistemas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->integer('Cantidad');
            $table->string('Nombre',35);
            $table->string('Marca',25)->nullable();
            $table->string('Modelo',45)->nullable();
            $table->string('NumeroSerie',30)->nullable();
            $table->text('Comentarios')->nullable();
            $table->integer('Estatus')->default(1);

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
        Schema::dropIfExists('hardware_sistemas');
    }
}
