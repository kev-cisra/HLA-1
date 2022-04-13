<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrecioAdicionalToCotizacionesSistemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizaciones_sistemas', function (Blueprint $table) {
            $table->float('CostoExtra',10,2)->after('TipoCambio')->nullable();
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
            $table->dropColumn("PrecioExtra");
        });
    }
}
