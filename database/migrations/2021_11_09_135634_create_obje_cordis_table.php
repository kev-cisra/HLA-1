<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjeCordisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obje_cordis', function (Blueprint $table) {
            $table->id();

            $table->enum('estatus', [1, 2, 3, 4])->default(1)->nullable();

            $table->unsignedBigInteger('maq_pro_id')->nullable();
            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('norma')->nullable();
            $table->foreign('norma')->references('id')->on('dep_mats')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('clave_id')->nullable();
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references("id")->on("departamentos")
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
        Schema::dropIfExists('obje_cordis');
    }
}
