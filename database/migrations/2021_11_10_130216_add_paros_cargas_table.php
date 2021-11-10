<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParosCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paros_cargas', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('paros_carga_id')->nullable()->after('proceso_id');
            $table->foreign('paros_carga_id')->references("id")->on("paros_cargas")
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
        Schema::table('paros_cargas', function (Blueprint $table) {
            //
            $table->dropForeign('paros_cargas_paros_carga_id_foreign');
            $table->dropColumn('paros_carga_id');
        });
    }
}
