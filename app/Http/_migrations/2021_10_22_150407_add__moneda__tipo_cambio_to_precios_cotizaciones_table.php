<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonedaTipoCambioToPreciosCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('precios_cotizaciones', function (Blueprint $table) {
            $table->string('Moneda',5)->default('MXN')->nullable()->after('Total');
            $table->string('TipoCambio',13)->default(0)->nullable()->after('Moneda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('precios_cotizaciones', function (Blueprint $table) {
            $table->dropColumn('Moneda');
            $table->dropColumn('TipoCambio');
        });
    }
}
