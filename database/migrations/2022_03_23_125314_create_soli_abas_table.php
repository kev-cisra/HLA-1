<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoliAbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soli_abas', function (Blueprint $table) {
            $table->id();
            $table->string('estatus')->nullable();
            $table->float('total_soli')->nullable()->default(0);

            $table->unsignedBigInteger('admi_abas_id');
            $table->foreign("admi_abas_id")->references("id")->on("admi_abas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_solicita');
            $table->foreign("depa_solicita")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_entregar');
            $table->foreign("depa_entregar")->references("id")->on("departamentos")
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
        Schema::dropIfExists('soli_abas');
    }
}
