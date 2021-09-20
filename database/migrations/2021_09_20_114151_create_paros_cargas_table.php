<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParosCargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paros_cargas', function (Blueprint $table) {
            $table->id();

            $table->dateTimeTz('fecha');
            $table->dateTimeTz('iniFecha');
            $table->dateTimeTz('finFecha')->nullable();
            $table->string('tiempo')->nullable();

            $table->unsignedBigInteger('perfil_ini_id');
            $table->unsignedBigInteger('perfil_fin_id')->nullable();
            $table->unsignedBigInteger('maq_pro_id')->nullable();
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedBigInteger('departamento_id')->nullable();

            $table->foreign('maq_pro_id')->references("id")->on("maq_pros")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign('proceso_id')->references("id")->on("procesos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign('perfil_ini_id')->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign('perfil_fin_id')->references("id")->on("perfiles_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign("departamento_id")->references("id")->on("departamentos")
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
        Schema::dropIfExists('paros_cargas');
    }
}
