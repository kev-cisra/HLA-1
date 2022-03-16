<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarioMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario_mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->text('title',65);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->text('textColor',15)->nullable();
            $table->text('backgroundColor',15)->nullable();
            $table->timestamp('FechaReal')->nullable();
            $table->double('Diferencia')->nullable();
            $table->string('Periodo',10);
            $table->string('Tiempo',15);
            $table->integer('Estatus')->default(0);
            $table->text('Comentarios')->nullable();

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
        Schema::dropIfExists('calendario_mantenimientos');
    }
}
