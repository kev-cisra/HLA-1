<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacGraficasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac_graficas', function (Blueprint $table) {
            $table->id();
            $table->string('graTipo');
            $table->string('subtitulo')->nullable();
            $table->string('subIz')->nullable();
            $table->string('subDe')->nullable();
            $table->string('titulo')->nullable();
            $table->enum('rango', [1,2,3,4])->default(1)->nullable();
            $table->enum('propa', [1,2,3])->default(1)->nullable();
            $table->string('tipo')->nullable();
            $table->string('tipoParo')->nullable();

            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references("id")->on("departamentos")
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
        Schema::dropIfExists('pac_graficas');
    }
}
