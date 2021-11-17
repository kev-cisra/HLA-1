<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjeCordisTable extends Migration
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
            $table->double('pro_hora')->after('estatus')->nullable();
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
            $table->dropColumn('pro_hora');
        });
    }
}
