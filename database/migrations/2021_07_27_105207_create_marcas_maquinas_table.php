<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcasMaquinasTable extends Migration
{

    public function up()
    {
        Schema::create('marcas_maquinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Numero control empleado
            $table->string('Nombre',45);
            $table->unsignedBigInteger('maquinas_id');

            $table->foreign("maquinas_id")->references("id")->on("maquinas")
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
        Schema::dropIfExists('marcas_maquinas');
    }
}
