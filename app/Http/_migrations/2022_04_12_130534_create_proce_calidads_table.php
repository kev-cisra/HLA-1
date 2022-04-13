<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceCalidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proce_calidads', function (Blueprint $table) {
            $table->id();

            $table->string('partida');
            $table->enum('estatus', [0,1,2,3])->default(1);

            $table->unsignedBigInteger('proceso_id');
            $table->foreign("proceso_id")->references("id")->on("cata_proce_calidads")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('partida_id');
            $table->foreign("partida_id")->references("id")->on("admi_abas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('clave_id');
            $table->foreign("clave_id")->references("id")->on("claves")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('dep_mat_id');
            $table->foreign("dep_mat_id")->references("id")->on("dep_mats")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('maquina_id');
            $table->foreign("maquina_id")->references("id")->on("maquinas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('departamento_id');
            $table->foreign("departamento_id")->references("id")->on("departamentos")
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
        Schema::dropIfExists('proce_calidads');
    }
}
