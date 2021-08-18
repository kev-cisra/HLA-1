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

        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'Personal',
            'Icono' => 'fas fa-users',
            'Ruta' => 'Produccion/Personal',
            'Area' => '7',
        ]);

        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'Maquinas',
            'Icono' => 'fas fa-digital-tachograph',
            'Ruta' => 'Produccion/Maquinas',
            'Area' => '7',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'PERFILES',
            'Icono' => 'fas fa-users',
            'Ruta' => 'RecursosHumanos/PerfilesUsuarios',
            'Area' => '2',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'VACACIONES',
            'Icono' => 'fas fa-users',
            'Ruta' => 'RecursosHumanos/Vacaciones',
            'Area' => '2',
        ]);
    }
}
