<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreProfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('are_profs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('perfiles_usuarios_id');
            $table->foreign("perfiles_usuarios_id")->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('area_id');
            $table->foreign("area_id")->references("id")->on("areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

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
        Schema::dropIfExists('are_profs');
    }
}
