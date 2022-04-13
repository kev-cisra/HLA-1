<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumCotizacionToPreciosCotizaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('precios_cotizaciones', function (Blueprint $table) {
            $table->integer('NumCotizacion')->nullable()->after('NombreProveedor');
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
            $table->dropColumn('NumCotizacion');
        });
    }
}
