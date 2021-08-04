<?php

namespace Database\Seeders;

use App\Models\Administrador\Modulos;
use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'Procesos',
            'Icono' => 'fas fa-cogs',
            'Ruta' => 'Produccion/Procesos',
            'Area' => '7',
        ]);
        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'Materiales',
            'Icono' => 'fas fa-boxes',
            'Ruta' => 'Produccion/Materiales',
            'Area' => '7',
        ]);
    }
}
