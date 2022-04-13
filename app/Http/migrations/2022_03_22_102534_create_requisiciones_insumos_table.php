<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionesInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones_insumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->integer('Folio');
            $table->date('Fecha');
            $table->tinyInteger('Estatus')->default(1);

            $table->unsignedBigInteger('Perfil_id')->nullable();
            $table->foreign("Perfil_id")->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Departamento_id')->nullable();
            $table->foreign("Departamento_id")->references("id")->on("departamentos")
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
        Schema::dropIfExists('requisiciones_insumos');
    }
}
