<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEquiposDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipos', function (Blueprint $table) {
            //
            $table->string('cue_dia')->nullable()->after('turno_id');
            $table->string('max_dia')->nullable()->after('cue_dia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipos', function (Blueprint $table) {
            //
            $table->dropColumn('cue_dia');
            $table->dropColumn('max_dia');
        });
    }
}
