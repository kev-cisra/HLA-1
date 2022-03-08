<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCarNormsPartidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_norms', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('partida_id')->nullable();
            $table->foreign('partida_id')->references("id")->on("aba_entregas")
            ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_norms', function (Blueprint $table) {
            //
            $table->dropForeign('car_norms_partida_id_foreign');
        });
    }
}
