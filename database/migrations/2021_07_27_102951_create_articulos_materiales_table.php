<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_materiales', function (Blueprint $table) {
            $table->id();

            $table->string('clv_art');
            $table->string('descri');
            $table->string('uni_mi');
            $table->enum('estatus',[1,2,3])->default(1);

            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references("id")->on("materiales")
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
        Schema::dropIfExists('articulos_materiales');
    }
}
