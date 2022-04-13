<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareAsignadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_asignados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->date('FechaAsignacion');
            $table->string('SubArea',25);
            $table->string('Ubicacion',15);
            $table->text('Comentarios')->nullable();
            $table->integer('Estatus')->default(0);

            $table->unsignedBigInteger('Hardware_id');
            $table->foreign("Hardware_id")->references("id")->on("hardware_sistemas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Perfil_id')->nullable();
            $table->foreign("Perfil_id")->references("id")->on("perfiles_usuarios")
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
        Schema::dropIfExists('hardware_asignados');
    }
}
