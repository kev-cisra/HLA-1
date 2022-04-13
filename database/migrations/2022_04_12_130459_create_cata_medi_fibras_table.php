<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCataMediFibrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cata_medi_fibras', function (Blueprint $table) {
            $table->id();

            $table->string('min_ml');
            $table->string('max_ml');
            $table->string('min_sfc');
            $table->string('max_sfc');
            $table->string('min_anillo');
            $table->string('max_anillo');
            $table->string('min_algodon');
            $table->string('max_algodon');

            $table->unsignedBigInteger('clave_id');
            $table->foreign("clave_id")->references("id")->on("claves")
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
        Schema::dropIfExists('cata_medi_fibras');
    }
}
