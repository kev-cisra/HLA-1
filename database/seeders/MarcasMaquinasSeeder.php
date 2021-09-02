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
            'Nombre' => 'DAVIZZI',
            'maquinas_id' => '1',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'OVC',
            'maquinas_id' => '2',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARGASA',
            'maquinas_id' => '3',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARTELL',
            'maquinas_id' => '4',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'DAVIZZI',
            'maquinas_id' => '5',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARGASA',
            'maquinas_id' => '6',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'MARGASA',
            'maquinas_id' => '7',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'SIN MARCA',
            'maquinas_id' => '8',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'SIN MARCA',
            'maquinas_id' => '9',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'SIN MARCA',
            'maquinas_id' => '10',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'ROSIQUE',
            'maquinas_id' => '11',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'CLARK',
            'maquinas_id' => '12',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'INGERSOLL RAND',
            'maquinas_id' => '13',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'INGERSOLL RAND',
            'maquinas_id' => '14',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'SIN MARCA',
            'maquinas_id' => '15',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'APERTURA',
            'maquinas_id' => '16',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'APERTURA',
            'maquinas_id' => '17',
        ]);

        MarcasMaquinas::create([
            'IdUser' => '1',
            'Nombre' => 'OMT',
            'maquinas_id' => '18',
        ]);
    }
}
