<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarOpesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_opes', function (Blueprint $table) {
            $table->id();

            $table->enum('estatus', [1,2,3])->default(1);

            $table->unsignedBigInteger('proceso_id');
            $table->foreign('proceso_id')->references("id")->on("procesos")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('dep_perf_id');
            $table->foreign('dep_perf_id')->references("id")->on("dep_pers")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('maq_pro_id')->nullable();
            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
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
        Schema::dropIfExists('car_opes');
    }
}
