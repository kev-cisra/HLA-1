<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaEstatusToRequisiciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->date('Fecha')->nullable()->after('IdEmp');
            $table->integer('Estatus')->nullable()->after('Perfil_id');
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
            $table->dropColumn('IdEmp');
            $table->dropColumn('Perfil_id');
        });
    }
}
