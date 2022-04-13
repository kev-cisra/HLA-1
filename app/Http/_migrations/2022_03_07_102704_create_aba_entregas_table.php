<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbaEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aba_entregas', function (Blueprint $table) {
            $table->id();

            $table->string('partida')->nullable()->unique();
            $table->string('folio')->nullable();
            $table->string('folio2')->nullable();
            $table->string('banco')->nullable();
            $table->string('esta_inicio')->nullable();
            $table->string('esta_final')->nullable();
            $table->float('total')->nullable();

            $table->unsignedBigInteger('norma_id')->nullable();
            $table->foreign('norma_id')->references('id')->on('dep_mats')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('clave_id')->nullable();
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_entrega');
            $table->foreign("depa_entrega")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_recibe');
            $table->foreign("depa_recibe")->references("id")->on("departamentos")
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
        Schema::dropIfExists('aba_entregas');
    }
}
