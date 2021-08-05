<?php

use App\Models\Produccion\catalogos\procesos;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos', function (Blueprint $table) {
            $table->id();

            $table->string('nompro');
            $table->enum('tipo',[procesos::Encargado, procesos::Coordinador, procesos::Formulas]);
            $table->string('descripcion')->nullable();
            $table->enum('estatus',[1,2,3])->default(1);

            $table->unsignedBigInteger('proceso_id')->nullable();
            $table->foreign('proceso_id')->references("id")->on("areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references("id")->on("areas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->timestamps();
            $table->softDeletes(); //Columna para soft delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procesos');
    }
}
