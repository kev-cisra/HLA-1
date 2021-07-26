<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\once;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->id();
            $table->string('nompro');
            $table->string('tipo');
            $table->string('descripcion');
            $table->integer('estatus');
            $table->timestamps();

            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references("id")->on("areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");
///asdasd
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procesos');
    }
}
