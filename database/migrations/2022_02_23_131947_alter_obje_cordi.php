<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterObjeCordi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obje_cordis', function (Blueprint $table) {
            //
            $table->string('tipo')->nullable()->after('estatus');
            $table->string('tiempo')->nullable()->after('pro_hora');
            $table->string('eficiencia')->nullable()->after('tiempo');
            $table->string('velocidad')->nullable()->after('eficiencia');
            $table->string('constante')->nullable()->after('velocidad');
            $table->string('cabos')->nullable()->after('constante');
            $table->string('titulo')->nullable()->after('cabos');
            $table->string('formula')->nullable()->after('titulo');
            $table->string('husos')->nullable()->after('cabos');
            $table->string('tipo_maqui')->nullable()->after('tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obje_cordis', function (Blueprint $table) {
            //
            $table->dropColumn('tipo');
            $table->dropColumn('tiempo');
            $table->dropColumn('eficiencia');
            $table->dropColumn('velocidad');
            $table->dropColumn('constante');
            $table->dropColumn('cabos');
            $table->dropColumn('titulo');
            $table->dropColumn('formula');
            $table->dropColumn('husos');
            $table->dropColumn('tipo_maqui');
        });
    }
}
