<?php

namespace Database\Seeders;

use App\Models\Administrador\Catalogos\AreasModulos;
use Illuminate\Database\Seeder;

class AreasModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreasModulos::create([
            'Area' => 'Administrador',
        ]);

        AreasModulos::create([
            'Area' => 'RecursosHumanos',
        ]);

        AreasModulos::create([
            'Area' => 'Almacen',
        ]);

        AreasModulos::create([
            'Area' => 'Compras',
        ]);

        AreasModulos::create([
            'Area' => 'Contabilidad',
        ]);

        AreasModulos::create([
            'Area' => 'Direccion',
        ]);

        AreasModulos::create([
            'Area' => 'Produccion',
        ]);

        AreasModulos::create([
            'Area' => 'Supply',
        ]);

        AreasModulos::create([
            'Area' => 'Sistemas',
        ]);
    }
}
