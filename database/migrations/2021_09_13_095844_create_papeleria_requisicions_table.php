<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class CreatePapeleriaRequisicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papeleria_requisicions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdUser')->nullable(); //Id de Session
            $table->unsignedBigInteger('IdEmp'); //Numero control empleado

            $table->date('Fecha');

            $table->unsignedBigInteger('Departamento_id')->Nullable();

            $table->foreign("Departamento_id")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('jefes_areas_id')->nullable();

            $table->foreign("jefes_areas_id")->references("id")->on("jefes_areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->string('Comentarios')->nullable();
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
        Schema::dropIfExists('papeleria_requisicions');
    }
}
