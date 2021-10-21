<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosPapeleriaRequisicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_papeleria_requisicions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado

            $table->integer('Cantidad');

            $table->unsignedBigInteger('material_id'); //Numero control empleado

            $table->foreign("material_id")->references("id")->on("material_papelerias")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('papeleria_id'); //Numero control empleado

            $table->foreign("papeleria_id")->references("id")->on("papeleria_requisicions")
            ->onDelete("cascade")
            ->onUpdate("cascade");

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
        Schema::dropIfExists('articulos_papeleria_requisicions');
    }
}
