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

            $table->date('fecha');
            $table->string('semana');
            $table->double('valor')->nullable();
            $table->enum('notaPen', [1,2])->default(1)->nullable();
            $table->string('nota')->nullable();
            $table->unsignedBigInteger('cargado')->nullable();
            $table->tinyInteger('equipo');

            $table->unsignedBigInteger('dep_perf_id');
            $table->unsignedBigInteger('maq_pro_id');
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedBigInteger('clave_id');
            $table->unsignedBigInteger('turno_id');

            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('proceso_id')->references("id")->on("procesos")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('dep_perf_id')->references("id")->on("dep_pers")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('turno_id')->references("id")->on("turnos")
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
        Schema::dropIfExists('carga_produccions');
    }
}
