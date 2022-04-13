<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerfilIdToVacaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacaciones', function (Blueprint $table) {

            $table->unsignedBigInteger('Perfil_id')->after('MotivoCancelacion')->nullable();

            $table->foreign("Perfil_id")->references("id")->on("perfiles_usuarios")
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
        Schema::table('vacaciones', function (Blueprint $table) {
            $table->dropColumn('Perfil_id');
        });
    }
}
