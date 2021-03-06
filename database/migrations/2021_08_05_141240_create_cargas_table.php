<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargas', function (Blueprint $table) {
            $table->id();

            $table->dateTimeTz('fecha');
            $table->string('semana');
            $table->double('valor')->nullable();
            $table->string('partida')->nullable();
            $table->enum('notaPen', [1,2,3])->default(1)->nullable();
            $table->enum('estatus', [1,2,3])->default(1)->nullable();
            $table->enum('est_ent', [1,2,3,4,5,6])->nullable();

            $table->unsignedBigInteger('equipo_id')->nullable();
            $table->unsignedBigInteger('dep_perf_id')->nullable();
            $table->unsignedBigInteger('per_carga')->nullable();
            $table->unsignedBigInteger('maq_pro_id')->nullable();
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedBigInteger('norma')->nullable();
            $table->unsignedBigInteger('clave_id')->nullable();
            $table->unsignedBigInteger('turno_id')->nullable();

            $table->foreign('norma')->references('id')->on('dep_mats')
            ->onUpdate('cascade');
            $table->foreign('equipo_id')->references("id")->on("equipos")
            ->onUpdate("cascade");
            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
            ->onUpdate("cascade");
            $table->foreign('proceso_id')->references("id")->on("procesos")
            ->onUpdate("cascade");
            $table->foreign('per_carga')->references("id")->on("perfiles_usuarios")
            ->onUpdate("cascade");
            $table->foreign('dep_perf_id')->references("id")->on("dep_pers")
            ->onUpdate("cascade");
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onUpdate("cascade");
            $table->foreign('turno_id')->references("id")->on("turnos")
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
        Schema::dropIfExists('carga_produccions');
    }
}
