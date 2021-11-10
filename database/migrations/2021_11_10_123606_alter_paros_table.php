<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterParosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paros', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('paro_id')->nullable()->after('tipo');
            $table->foreign('paro_id')->references('id')->on('paros')
            ->onDelete("cascade")
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
        Schema::table('paros', function (Blueprint $table) {
            //
            $table->dropForeign('paros_paro_id_foreign');
            $table->dropColumn('paro_id');
        });
    }
}
