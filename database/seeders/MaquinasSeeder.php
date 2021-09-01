<?php

namespace Database\Seeders;

use App\Models\Catalogos\Maquinas;
use Illuminate\Database\Seeder;

class MaquinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Maquinas::create([
            'IdUser' => '1',
            'Nombre' => 'CORTADORA',
            'Departamento' => 'APERTURA',
        ]);

        Maquinas::create([
            'IdUser' => '1',
            'Nombre' => 'ROMPEDORA',
            'Departamento' => 'APERTURA',
        ]);

        Maquinas::create([
            'IdUser' => '1',
            'Nombre' => 'PRENSA',
            'Departamento' => 'APERTURA',
        ]);
    }
}
