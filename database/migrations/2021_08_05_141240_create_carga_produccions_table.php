<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaProduccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_produccions', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');
            $table->string('semana');
            $table->double('valor')->nullable();
            $table->enum('notaPen', [1,2])->default(1)->nullable();
            $table->string('nota')->nullable();
            $table->unsignedBigInteger('cargado')->nullable();
            $table->tinyInteger('equipo');

            $table->unsignedBigInteger('are_perf_id');
            $table->unsignedBigInteger('maq_pro_id');
            $table->unsignedBigInteger('clave_id');
            $table->unsignedBigInteger('turno_id');

            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('are_perf_id')->references("id")->on("are_profs")
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
