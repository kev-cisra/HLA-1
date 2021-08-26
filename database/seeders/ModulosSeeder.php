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
            'NombreModulo' => 'PROCESOS',
            'Icono' => 'fas fa-cogs',
            'Ruta' => 'Produccion/Procesos',
            'Area' => '7',
        ]);

        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'MAQUINAS',
            'Icono' => 'fas fa-digital-tachograph',
            'Ruta' => 'Produccion/Maquinas',
            'Area' => '7',
        ]);

        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'PERSONAL',
            'Icono' => 'fas fa-users',
            'Ruta' => 'Produccion/Personal',
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
            'Icono' => 'fas fa-calendar-check',
            'Ruta' => 'RecursosHumanos/Vacaciones',
            'Area' => '2',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'REPORTE VACACIONES',
            'Icono' => 'fas fa-file-contract',
            'Ruta' => 'RecursosHumanos/ReporteVacaciones',
            'Area' => '2',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'INCIDENCIAS',
            'Icono' => 'fas fa-user-plus',
            'Ruta' => 'RecursosHumanos/Incidencias',
            'Area' => '2',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'REPORTE INCIDENCIAS',
            'Icono' => 'fas fa-file-invoice',
            'Ruta' => 'RecursosHumanos/ReporteIncidencias',
            'Area' => '2',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'TURNOS',
            'Icono' => 'fas fa-user-clock',
            'Ruta' => 'Produccion/Turnos',
            'Area' => '7',
        ]);

        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'MATERIALES',
            'Icono' => 'fas fa-boxes',
            'Ruta' => 'Produccion/Materiales',
            'Area' => '7',
        ]);

        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'CLAVES',
            'Icono' => 'fas fa-truck-loading',
            'Ruta' => 'Produccion/Clamat',
            'Area' => '7',
        ]);

        /*Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'EQUIPO',
            'Icono' => 'fas fa-people-carry',
            'Ruta' => 'Produccion/Equipo',
            'Area' => '7',
        ]);*/
    }
}
