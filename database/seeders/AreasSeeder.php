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
            'idArea' => 'PRO',
            'Nombre' => 'PRODUCCION',
            'areas_id' => NULL,
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'APT',
            'Nombre' => 'APERTURA',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'HL1',
            'Nombre' => 'HILATURA 1',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'HL2',
            'Nombre' => 'HILATURA 2',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'HL3',
            'Nombre' => 'HILATURA 3',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'ANI',
            'Nombre' => 'ANILLO',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'PRE',
            'Nombre' => 'PREPARACION',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'TEJ',
            'Nombre' => 'TEJIDO',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'CAL',
            'Nombre' => 'CALIDAD',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'idArea' => 'SRG',
            'Nombre' => 'SERVICIOS GENERALES',
            'areas_id' => '1',
        ]);
    }
}
