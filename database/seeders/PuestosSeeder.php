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
        ]);

        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASESOR DE VENTAS',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASESOR TECNICO',
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
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ASISTENTE DE OPERACIONES',
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
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'GERENTE DE OPERACIONES',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'COORDINADOR EN OPERACIONES',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'ENCARGADO EN OPERACIONES',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'LIDER EN OPERACIONES',
        ]);
        Puestos::create([
            'IdUser' => '1',
            'Nombre' => 'OPERADOR OPERACIONES',
        ]);
    }
}
