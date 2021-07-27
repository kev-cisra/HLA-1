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
            'Nombre' => 'APERTURA',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 1',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 2',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'HILATURA 3',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'ANILLO',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'PREPARACION',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'TEJIDO',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'CALIDAD',
        ]);

        Areas::create([
            'IdUser' => '1',
            'Nombre' => 'SERVICIOS GENERALES',
        ]);
    }
}
