<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoRechazoToArticulosRequisiciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulos_requisiciones', function (Blueprint $table) {
            $table->string('MotivoRechazo')->nullable()->after('MotivoCancelacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulos_requisiciones', function (Blueprint $table) {
            $table->dropColumn('MotivoRechazo');
        });
    }
}
