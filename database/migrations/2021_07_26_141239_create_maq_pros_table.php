<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaqProsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maq_pros', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('proceso_id');
            $table->foreign('proceso_id')->references("id")->on("procesos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('maquina_id');
            $table->foreign('maquina_id')->references("id")->on("maquinas")
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
        Schema::dropIfExists('maq_pros');
    }
}
