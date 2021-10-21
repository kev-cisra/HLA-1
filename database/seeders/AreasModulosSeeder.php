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
            'IdUser' => '1',
            'NombreArea' => 'Administrador',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'RecursosHumanos',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Almacen',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Compras',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Contabilidad',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Direccion',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Produccion',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Supply',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Sistemas',
        ]);

        AreasModulos::create([
            'IdUser' => '1',
            'NombreArea' => 'Hilaturas',
        ]);
    }
}
