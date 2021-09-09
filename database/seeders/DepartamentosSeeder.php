<?php

namespace Database\Seeders;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'ADMINISTRATIVO',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'OPERACIONES',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'ALMACEN MAT PRIMA',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 1',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 2',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 3',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'APERTURA',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA DE ANILLO',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'LABORATORIO Y BONETERIA',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'LOGISTICA',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'MANTENIMIENTO',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'SEG Y SERVICIOS GENERALES',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'TEJIDO',

        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'COMPRAS',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'CONTABILIDAD',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'SISTEMAS',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'DIRECCION',
        ]);
    }
}
