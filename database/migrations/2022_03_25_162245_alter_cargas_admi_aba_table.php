<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCargasAdmiAbaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cargas', function (Blueprint $table) {
            //
            $table->dropForeign('cargas_partida_id_foreign');
            //$table->dropColumn("partida_id");

            //$table->unsignedBigInteger('partida_id')->nullable()->after('clave_id');
            $table->foreign('partida_id')->references("id")->on("admi_abas")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_ubicacion')->after('departamento_id')->nullable();
            $table->foreign("depa_ubicacion")->references("id")->on("departamentos")
            ->onDelete("cascade")
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
        Schema::table('cargas', function (Blueprint $table) {
            //
            $table->dropForeign('cargas_partida_id_foreign');

            //$table->unsignedBigInteger('partida_id')->nullable()->after('proceso_id');
            $table->foreign('partida_id')->references("id")->on("aba_entregas")
            ->onUpdate("cascade");

            $table->dropForeign('cargas_depa_ubicacion_foreign');
            $table->dropColumn("depa_ubicacion");
        });
    }
}
