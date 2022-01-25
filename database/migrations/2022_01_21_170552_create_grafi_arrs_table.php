<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrafiArrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grafi_arrs', function (Blueprint $table) {
            $table->id();

            $table->string('tipo')->nullable();

            $table->unsignedBigInteger('pac_grafica_id');
            $table->foreign('pac_grafica_id')->references("id")->on("pac_graficas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            /* $table->unsignedBigInteger('paro_id');
            $table->foreign('paro_id')->references("id")->on("paros")
            ->onDelete("cascade")
            ->onUpdate("cascade"); */

            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')->references("id")->on("materiales")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('maq_pro_id')->nullable();
            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('proceso_id')->nullable();
            $table->foreign('proceso_id')->references("id")->on("procesos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('maq_pro_linea_id')->nullable();
            $table->foreign('maq_pro_linea_id')->references("id")->on("maq_pros")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('proceso_linea_id')->nullable();
            $table->foreign('proceso_linea_id')->references("id")->on("procesos")
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
        Schema::dropIfExists('grafi_arrs');
    }
}
