<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmiAbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admi_abas', function (Blueprint $table) {
            $table->id();

            $table->string('partida')->nullable()->unique();
            $table->string('folio2')->nullable();
            $table->float('total')->nullable()->default(0);
            $table->string('estatus')->nullable();

            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->foreign('perfil_id')->references("id")->on("perfiles_usuarios")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->foreign('departamento_id')->references("id")->on("departamentos")
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
        Schema::dropIfExists('admi_abas');
    }
}
