<?php

namespace Database\Seeders;

use App\Models\RecursosHumanos\Catalogos\JefesArea;
use Illuminate\Database\Seeder;

class JefesAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '41',
            'Nombre' => 'JAVIER PEREZ GIL',
            'Area' => 'ADMINISTRATIVO',
        ]);
        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '22',
            'Nombre' => 'RODOLFO REYES GARCIA',
            'Area' => 'OPERACIONES',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '70',
            'Nombre' => 'DIANA MUÑOZ HERRERA',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '28',
            'Nombre' => 'JUAN PABLO QUINTANA',
            'Area' => 'SUPPLY MANAGER',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '9898',
            'Nombre' => 'ALBERTO AGUILAR',
            'Area' => 'CONTRALORIA',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '13',
            'Nombre' => 'LEYDEN LOPEZ',
            'Area' => 'RECURSOS HUMANOS',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '53',
            'Nombre' => 'GERARDO LOPEZ ROSALES',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '21',
            'Nombre' => 'JOSE ALFONSO',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '32',
            'Nombre' => 'RICARDO CASTILLO OLIVER',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '10',
            'Nombre' => 'ARTURO RODRIGUEZ CARMONA',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '49',
            'Nombre' => 'JUAN JOSE MENDOZA PASTRANA',
            'Area' => 'COMERCIAL',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '83',
            'Nombre' => 'GERARDO ROJAS GARCIA',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '64',
            'Nombre' => 'PATRICIA RODRIGUEZ NESME',
            'Area' => 'ADMINISTRATIVO',
        ]);


        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '43',
            'Nombre' => 'BEATRIZ JARAMILLO NOLASCO',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '99999',
            'Nombre' => 'PEDRO MUÑOZ',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '1263',
            'Nombre' => 'ISRAEL CORONA',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '516',
            'Nombre' => 'RAFAEL PARRAGUIRRE GARCIA',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '53',
            'Nombre' => 'GERARDO LOPEZ ROSALES',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '1225',
            'Nombre' => 'MIGUEL ANGEL HERNANDEZ RODIRGUEZ',
            'Area' => 'ADMINISTRATIVO',
        ]);

        JefesArea::create([
            'IdUser' => '1',
            'IdEmp' => '1235',
            'Nombre' => 'FERNANDO MADRIGAL RANGEL',
            'Area' => 'ADMINISTRATIVO',
        ]);
    }
}
