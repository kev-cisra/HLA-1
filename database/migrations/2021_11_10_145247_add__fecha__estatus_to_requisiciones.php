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
            // $table->unsignedBigInteger('IdEmp')->after('IdUser'); //Numero control empleado
            $table->date('Fecha')->nullable()->after('IdEmp');
            $table->integer('Estatus')->nullable()->after('Perfil_id');
            $table->integer('OrdenCompra')->nullable()->after('NumReq')->default(0);
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
            $table->dropColumn('Fecha');
            $table->dropColumn('Estatus');
            $table->dropColumn('OrdenCompra');
        });
    }
}
