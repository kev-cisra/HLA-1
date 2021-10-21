<?php

namespace Database\Seeders;

use App\Models\Produccion\paros as ProduccionParos;
use Illuminate\Database\Seeder;

class paros extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ProduccionParos::create([
            'clave' => 'AEE',
            'descri' => 'Ahorro energía eléctrica',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'DDE',
            'descri' => 'Días determinados por la empresa',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'MP',
            'descri' => 'Mantenimiento Preventivo',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'PPP',
            'descri' => 'Paros Programados por Producción',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FB',
            'descri' => 'Falta de Bote Vacío',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'CM',
            'descri' => 'Cambio de Material',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'AM',
            'descri' => 'Ajuste(s) mantenimiento /máquina',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'AL',
            'descri' => 'Análisis Laboratorio',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'EM',
            'descri' => 'Enderezar Máquina',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'CF',
            'descri' => 'Cambio de Fresa (cuarto)',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FMP',
            'descri' => 'Falta de Materia Prima',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'L',
            'descri' => 'Limpieza',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FM',
            'descri' => 'Falla Mecánica',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'F',
            'descri' => 'Falla Eléctrica',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'MCMP',
            'descri' => 'Mala Calidad Materia Prima',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FE',
            'descri' => 'Falla Electrónica',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FEE',
            'descri' => 'Falla En Empalmador',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FDI',
            'descri' => 'Falta De Insumos ',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FSE',
            'descri' => 'Falla Sistema Empaque',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'CP',
            'descri' => 'Cambio de Producto',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'CE',
            'descri' => 'Corte de Energía Eléctrica',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FR',
            'descri' => 'Falta de Refacción',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'MC',
            'descri' => 'Mala Calidad(U%,neps,etc.)',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'RM',
            'descri' => 'Reajuste de Máquina',
            'tipo' => '1'
        ]);
        ProduccionParos::create([
            'clave' => 'FO',
            'descri' => 'Falla Operativa',
            'tipo' => '1'
        ]);
    }
}
