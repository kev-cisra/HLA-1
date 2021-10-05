<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proc_rela');
            $table->foreign('proc_rela')->references("id")->on("procesos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('maq_pros_id')->nullable();
            $table->foreign('maq_pros_id')->references("id")->on("maq_pros")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('proceso_id')->nullable();
            $table->foreign('proceso_id')->references("id")->on("procesos")
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
        Schema::dropIfExists('formulas');
    }
}
