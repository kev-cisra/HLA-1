<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelaAbaCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rela_aba_cargas', function (Blueprint $table) {
            $table->string('estatus')->nullable();
            $table->unsignedBigInteger('carga_id')->nullable();
            $table->foreign('carga_id')->references("id")->on("cargas")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('aba_entre_id')->nullable();
            $table->foreign('aba_entre_id')->references('id')->on('aba_entregas')
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
        Schema::dropIfExists('rela_aba_cargas');
    }
}
