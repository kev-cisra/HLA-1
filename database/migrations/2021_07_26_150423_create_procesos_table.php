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
            $table->string('descripcion')->nullable();
            $table->enum('estatus',[1,2,3])->default(1);

            $table->unsignedBigInteger('areas_id');
            $table->foreign('areas_id')->references("id")->on("areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->timestamps();
            $table->softDeletes(); //Columna para soft delete
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
