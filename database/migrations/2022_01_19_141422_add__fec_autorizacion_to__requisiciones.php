<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFecAutorizacionToRequisiciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dateTime('FecAutorizacion')->nullable()->after('Estatus');
            $table->integer('Etiqueta')->nullable()->after('FecAutorizacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            // $table->dropColumn('FecAutorizacion');
            // $table->dropColumn('Etiqueta');
        });
    }
}
