<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParoObjesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paro_objes', function (Blueprint $table) {
            $table->id();

            $table->float('horas')->default(0);

            $table->unsignedBigInteger('paro_id');
            $table->foreign("paro_id")->references("id")->on("paros")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('carga_id');
            $table->foreign("carga_id")->references("id")->on("cargas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->softDeletes(); //Columna para soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paro_objes');
    }
}
