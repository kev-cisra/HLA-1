<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargProcMeFibrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carg_proc_me_fibras', function (Blueprint $table) {
            $table->id();

            $table->enum('estatus', [0,1,2,3,4])->defalt(1);
            $table->enum('frecuencia', [0,1,2,3,4])->default(1);
            $table->float('ml')->nullable();
            $table->float('sfc')->nullable();
            $table->float('ani_cal')->nullable();
            $table->float('algod_cal')->nullable();
            $table->float('composi')->nullable();

            $table->unsignedBigInteger('proce_calidad_id')->nullable();
            $table->foreign("proce_calidad_id")->references("id")->on("proce_calidads")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('cata_medi_fibra_id')->nullable();
            $table->foreign("cata_medi_fibra_id")->references("id")->on("cata_medi_fibras")
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
        Schema::dropIfExists('carg_proc_me_fibras');
    }
}
