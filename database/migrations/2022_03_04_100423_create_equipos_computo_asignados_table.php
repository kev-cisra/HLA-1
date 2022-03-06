<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposComputoAsignadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_computo_asignados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser'); //Id de Session
            $table->date('FechaAsignacion');
            $table->string('SubArea',25);
            $table->string('Ubicacion',15);
            $table->text('Comentarios')->nullable();
            $table->integer('Estatus')->default(0);

            $table->unsignedBigInteger('EquipoComputo_id');
            $table->foreign("EquipoComputo_id")->references("id")->on("equipos_computos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('EquipoComputo_id');
            $table->foreign("EquipoComputo_id")->references("id")->on("equipos_computos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('Perfil_id')->after('MotivoCancelacion')->nullable();

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
        Schema::dropIfExists('equipos_computo_asignados');
    }
}
