<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paros', function (Blueprint $table) {
            $table->id();

            $table->string('clave')->unique();
            $table->string('descri')->nullable();
            $table->enum('tipo', [1,2,3,4,5,6])->nullable();

            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->foreign("departamento_id")->references("id")->on("departamentos")
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
        Schema::dropIfExists('paros');
    }
}
