<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivoPuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivo_puntas', function (Blueprint $table) {
            $table->id();

            $table->string('horas')->nullable();
            $table->double('valorPu')->nullable();

            $table->unsignedBigInteger('carga_id')->nullable();
            $table->foreign('carga_id')->references('id')->on('cargas')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('objetivo_puntas');
    }
}
