<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClavesColumnasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claves', function (Blueprint $table) {
            //
            $table->string('torsion')->after('categoria')->nullable();
            $table->string('color')->after('torsion')->nullable();
            $table->string('calibre')->after('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claves', function (Blueprint $table) {
            //
            $table->dropColumn('torsion');
            $table->dropColumn('color');
            $table->dropColumn('calibre');
        });
    }
}
