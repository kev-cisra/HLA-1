<?php

namespace Database\Seeders;

use App\Models\Catalogos\MarcasMaquinas;
use Illuminate\Database\Seeder;

class MarcasMaquinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'OMT BIELA',
            'maquinas_id' => '1',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARGASA',
            'maquinas_id' => '1',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARGASA',
            'maquinas_id' => '2',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'OVC',
            'maquinas_id' => '2',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'DAVICCI',
            'maquinas_id' => '3',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARGASA',
            'maquinas_id' => '3',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'POLVOS',
            'maquinas_id' => '3',
        ]);
    }
}
