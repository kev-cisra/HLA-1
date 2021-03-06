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
            'departamento_id' => '2'
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 1',
            'departamento_id' => '2'
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 2',
            'departamento_id' => '2'
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 3',
            'departamento_id' => '2'
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'APERTURA',
            'departamento_id' => '2'
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA DE ANILLO',
            'departamento_id' => '2'
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
            'departamento_id' => '2'
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'SEG Y SERVICIOS GENERALES',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'TEJIDO',
            'departamento_id' => '2'

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

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'PREPARACION',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'PREPARACION DE ANILLO',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'PREPARACION Y MOVIMIENTO',
        ]);

        Departamentos::create([
            'IdUser' => '1',
            'Nombre' => 'SHIELDTEX',
        ]);
    }
}
