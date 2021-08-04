<?php

namespace Database\Seeders;

use App\Models\RecursosHumanos\Catalogos\Areas;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Areas::create([
            'IdUser' => '1',
            'idArea' => 'OPE',
            'Nombre' => 'OPERACIONES',
            'tipo' => '1',
            'areas_id' => NULL,
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'PRO',
            'Nombre' => 'PRODUCCION',
            'tipo' => '1',
            'areas_id' => 1,
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'APT',
            'Nombre' => 'APERTURA',
            'tipo' => '2',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'HL1',
            'Nombre' => 'HILATURA 1',
            'tipo' => '3',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'HL2',
            'Nombre' => 'HILATURA 2',
            'tipo' => '3',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'HL3',
            'Nombre' => 'HILATURA 3',
            'tipo' => '3',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'ANI',
            'Nombre' => 'ANILLO',
            'tipo' => '2',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'PRE',
            'Nombre' => 'PREPARACION',
            'tipo' => '3',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'TEJ',
            'Nombre' => 'TEJIDO',
            'tipo' => '2',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'CAL',
            'Nombre' => 'CALIDAD',
            'tipo' => '2',
            'areas_id' => '2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'SRG',
            'Nombre' => 'SERVICIOS GENERALES',
            'tipo' => '2',
            'areas_id' => '2',
        ]);
    }
}
