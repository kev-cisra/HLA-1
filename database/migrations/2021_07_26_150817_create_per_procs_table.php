<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerProcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_procs', function (Blueprint $table) {
            $table->id();
            $table->enum('estatus',[1,2,3])->default(1);
            $table->unsignedBigInteger('perfil_id');
            $table->unsignedBigInteger('proceso_id');

            $table->foreign('perfil_id')->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            $table->foreign('proceso_id')->references("id")->on("procesos")
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
        Schema::dropIfExists('per_procs');
    }
}
