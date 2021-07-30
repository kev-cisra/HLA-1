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
            'Nombre' => 'PRODUCCION',
            'areas_id' => NULL,
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'APERTURA',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 1',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 2',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 3',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'ANILLO',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'PREPARACION',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'TEJIDO',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'CALIDAD',
            'areas_id' => '1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'SERVICIOS GENERALES',
            'areas_id' => '1',
        ]);
    }
}
