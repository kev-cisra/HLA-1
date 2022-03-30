<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmaAbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alma_abas', function (Blueprint $table) {
            $table->id();

            $table->integer('estatus')->nullable()->default(0);
            $table->float('total')->nullable()->default(0);

            $table->unsignedBigInteger('norma_id')->nullable();
            $table->foreign('norma_id')->references('id')->on('dep_mats')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('clave_id')->nullable();
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('soli_aba_id')->nullable();
            $table->foreign('soli_aba_id')->references("id")->on("soli_abas")
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
        Schema::dropIfExists('alma_abas');
    }
}
