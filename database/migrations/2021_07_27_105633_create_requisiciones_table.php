<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->id();
            $table->string('IdUser',6); //id de session
            $table->integer('Folio')->unique();
            $table->date('Fecha'); //fecha de solicitud
            $table->string('NomJefe',65);
            $table->integer('NumReq');
            $table->string('Area',45);
            $table->string('Codigo',45);
            $table->string('Maquina',45)->nullable();
            $table->string('Marca',45)->nullable();
            $table->string('TipCompra',45);
            $table->string('Observaciones')->nullable();
            $table->string('NomSolicitante',65)->nullable();
            $table->string('EstatusReq',15)->nullable();
            $table->string('ColorReq',35)->nullable();
            $table->string('OrdenCompra',10)->default('S/N');
            $table->text('MotivoCancelacion')->nullable();
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
        Schema::dropIfExists('requisiciones');
    }
}
