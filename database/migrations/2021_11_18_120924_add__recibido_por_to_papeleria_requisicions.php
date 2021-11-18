<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecibidoPorToPapeleriaRequisicions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('papeleria_requisicions', function (Blueprint $table) {
            $table->integer("RecibidoPor")->nullable()->after('Comentarios');
            $table->string('MotivoRechazo')->nullable()->after('RecibidoPor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papeleria_requisicions', function (Blueprint $table) {
            $table->dropColumn('RecibidoPor');
            $table->dropColumn('MotivoRechazo');
        });
    }
}
