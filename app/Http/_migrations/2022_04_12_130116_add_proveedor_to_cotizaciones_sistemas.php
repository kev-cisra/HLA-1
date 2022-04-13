<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProveedorToCotizacionesSistemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_sistemas', function (Blueprint $table) {
            $table->unsignedBigInteger('Proveedor_Sistemas_id')->nullable()->after('Archivo');
            $table->foreign('Proveedor_Sistemas_id')->references("id")->on("proveedores_sistemas")
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
        Schema::table('cotizaciones_sistemas', function (Blueprint $table) {
            $table->dropForeign('Proveedor_Sistemas_id');
            $table->dropColumn("Proveedor_Sistemas_id");
        });
    }
}
