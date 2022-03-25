<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAbaEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aba_entregas', function (Blueprint $table) {
            //
            $table->dropColumn("partida");
            $table->dropColumn('folio2');

            $table->unsignedBigInteger('perfi_abas')->nullable()->after('total');
            $table->foreign('perfi_abas')->references('id')->on('perfiles_usuarios')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('perfi_entrega')->nullable()->after('perfi_abas');
            $table->foreign('perfi_entrega')->references('id')->on('perfiles_usuarios')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('soli_aba_id')->nullable()->after('perfi_entrega');
            $table->foreign('soli_aba_id')->references("id")->on("soli_abas")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('admi_abas_id')->after('soli_aba_id');
            $table->foreign("admi_abas_id")->references("id")->on("admi_abas")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->dropForeign('aba_entregas_norma_id_foreign');
            $table->dropColumn("norma_id");

            $table->dropForeign('aba_entregas_clave_id_foreign');
            $table->dropColumn("clave_id");

            $table->dropForeign('aba_entregas_depa_entrega_foreign');
            $table->dropColumn("depa_entrega");

            $table->dropForeign('aba_entregas_depa_recibe_foreign');
            $table->dropColumn("depa_recibe");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aba_entregas', function (Blueprint $table) {
            //
            $table->string('partida')->nullable()->unique();
            $table->string('folio2')->nullable();

            $table->dropForeign('aba_entregas_perfi_abas_foreign');
            $table->dropColumn("perfi_abas");

            $table->dropForeign('aba_entregas_perfi_entrega_foreign');
            $table->dropColumn("perfi_entrega");

            $table->dropForeign('aba_entregas_soli_aba_id_foreign');
            $table->dropColumn("soli_aba_id");

            $table->dropForeign('aba_entregas_admi_abas_id_foreign');
            $table->dropColumn("admi_abas_id");

            $table->unsignedBigInteger('norma_id')->nullable();
            $table->foreign('norma_id')->references('id')->on('dep_mats')
            ->onUpdate('cascade');

            $table->unsignedBigInteger('clave_id')->nullable();
            $table->foreign('clave_id')->references("id")->on("claves")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_entrega');
            $table->foreign("depa_entrega")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->unsignedBigInteger('depa_recibe');
            $table->foreign("depa_recibe")->references("id")->on("departamentos")
            ->onDelete("cascade")
            ->onUpdate("cascade");
        });
    }
}
