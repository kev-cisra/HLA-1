<?php

namespace Database\Seeders;

use App\Models\RecursosHumanos\Catalogos\Puestos;
use Illuminate\Database\Seeder;

class PuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ADMINISTRACION DE CARTERA',
        ]);

        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ANALISTA DE PROCESOS',
            'departamento_id' => '2'
        ]);

        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ANALISTA DE VENTAS',
        ]);

        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASESOR COMERCIO EXTERIOR',
        ]);

        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASESOR DE CALIDAD',
            'departamento_id' => '2'
        ]);

        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASESOR DE VENTAS',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASESOR TECNICO',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASISTENTE CONTABLE',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASISTENTE DE DIRECCION',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASISTENTE DE OPERACIONES',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASISTENTE DE PROCESOS',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASISTENTE DE RECURSOS HUMANOS',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'AUXILIAR SISTEMAS',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'AUXILIAR TECNICO',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'AYUDANTE MANTTO CIVIL',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'JEFE DE OPERACION',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'COORDINADOR AREA TECNICA',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'OFICIAL EXPERTO H',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ENCARGADO MATTO MECANICO A',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ENCARGADO MATTO MECANICO B',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ENCARGADO MATTO MECANICO C',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ENCARGADO DE HILATURA DE ANILLO',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'OFICIAL EN DESARROLLO H',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'OFICIAL EN DESARROLLO',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'OFICIAL EXPERTO H',
            'departamento_id' => '2'
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'AYUDANTE DE MECANICO C',
            'departamento_id' => '2'
        ]);
    }
}
