<?php

namespace Database\Seeders;

use App\Models\Produccion\catalogos\procesos;
use Illuminate\Database\Seeder;

class ProcesosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        procesos::create(['id' => '1', 'nompro' => 'LINEA OVC', 'tipo' => '0', 'tipo_carga' => 'pro', 'proceso_id' => '', 'departamento_id' => '7']);
        procesos::create(['id' => '2', 'nompro' => 'LINEA MARGASA', 'tipo' => '0', 'tipo_carga' => 'pro', 'proceso_id' => '', 'departamento_id' => '7']);
        procesos::create(['id' => '3', 'nompro' => 'PACAS OVC', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '1', 'departamento_id' => '7']);
        procesos::create(['id' => '4', 'nompro' => 'PACAS MARGASA', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '2', 'departamento_id' => '7']);
        procesos::create(['id' => '5', 'nompro' => 'CORTE OMT', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '1', 'departamento_id' => '7']);
        procesos::create(['id' => '6', 'nompro' => 'ABIERTO OVC', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '1', 'departamento_id' => '7']);
        procesos::create(['id' => '7', 'nompro' => 'EMPAQUE OVC', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '1', 'departamento_id' => '7']);
        procesos::create(['id' => '8', 'nompro' => 'CORTE MARGASA', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '2', 'departamento_id' => '7']);
        procesos::create(['id' => '9', 'nompro' => 'ABIERTO MARGASA', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '2', 'departamento_id' => '7']);
        procesos::create(['id' => '10', 'nompro' => 'EMPAQUE MARGASA', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '2', 'departamento_id' => '7']);
        procesos::create(['id' => '11', 'nompro' => 'LINEA ROSIQUE', 'tipo' => '0', 'tipo_carga' => 'pro', 'proceso_id' => '', 'departamento_id' => '7']);
        procesos::create(['id' => '12', 'nompro' => 'CARDADO', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '11', 'departamento_id' => '7']);
        procesos::create(['id' => '13', 'nompro' => 'EMPAQUE ROSIQUE', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '11', 'departamento_id' => '7']);
        procesos::create(['id' => '14', 'nompro' => 'PACAS ROSIQUE', 'tipo' => '1', 'tipo_carga' => '', 'proceso_id' => '11', 'departamento_id' => '7']);
        procesos::create(['id' => '15', 'nompro' => 'OBJETIVO LINEA OVC', 'tipo' => '0', 'tipo_carga' => 'pro-cor', 'proceso_id' => '', 'departamento_id' => '7']);
        procesos::create(['id' => '16', 'nompro' => 'OBJETIVO CORTE OMT', 'tipo' => '2', 'tipo_carga' => '', 'proceso_id' => '15', 'departamento_id' => '7']);
        procesos::create(['id' => '17', 'nompro' => 'OBJETIVO ABIERTO OVC', 'tipo' => '2', 'tipo_carga' => '', 'proceso_id' => '15', 'departamento_id' => '7']);
        procesos::create(['id' => '18', 'nompro' => 'OBJETIVO LINEA MARGASA', 'tipo' => '0', 'tipo_carga' => 'pro-cor', 'proceso_id' => '', 'departamento_id' => '7']);
        procesos::create(['id' => '19', 'nompro' => 'OBJETIVO CORTE MARGASA', 'tipo' => '2', 'tipo_carga' => '', 'proceso_id' => '18', 'departamento_id' => '7']);
        procesos::create(['id' => '20', 'nompro' => 'OBJETIVO ABIERTO MARGASA', 'tipo' => '2', 'tipo_carga' => '', 'proceso_id' => '18', 'departamento_id' => '7']);
        procesos::create(['id' => '21', 'nompro' => 'OBJETIVO LINEA ROSIQUE', 'tipo' => '0', 'tipo_carga' => 'pro-cor', 'proceso_id' => '', 'departamento_id' => '7']);
        procesos::create(['id' => '22', 'nompro' => 'OBJETIVO CARDADO', 'tipo' => '2', 'tipo_carga' => '', 'proceso_id' => '21', 'departamento_id' => '7']);
    }
}
