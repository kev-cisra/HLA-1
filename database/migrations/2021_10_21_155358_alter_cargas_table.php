<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cargas', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('departamento_id')->after('turno_id');
            $table->foreign("departamento_id")->references("id")->on("departamentos")->after('turno_id')
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
        Schema::table('cargas', function (Blueprint $table) {
            //
        });
    }
}
