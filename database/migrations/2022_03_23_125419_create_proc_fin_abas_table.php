<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcFinAbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proc_fin_abas', function (Blueprint $table) {
            $table->id();

            $table->integer('estatus')->nullable()->default(0);

            $table->unsignedBigInteger('norma_id')->nullable();
            $table->foreign('norma_id')->references('id')->on('dep_mats')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('clave_id')->nullable();
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('admi_abas_id');
            $table->foreign("admi_abas_id")->references("id")->on("admi_abas")
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
        Schema::dropIfExists('proc_fin_abas');
    }
}
