<?php

namespace Database\Seeders;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Seeder;

class PerfilesUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PerfilesUsuarios::create([
            'IdUser' => '16',
            'IdEmp' => '78',
            'Empresa' => 'SERGES',
            'Nombre' => 'Kevin',
            'ApPat' => 'Cisneros',
            'ApMat' => 'Ramirez',
            'Curp' => 'asdasdas',
            'Rfc' => 'asdasdas',
            'Nss' => '3215564',
            'Direccion' => 'asdasdasd',
            'Telefono' => '21231561',
            'Cumpleaños' => '2010-07-09',
            'FecIng' => '2010-07-09',
            'Antiguedad' => '25',
            'DiasVac' => '12',
            'Puesto_id' => '13',
            'user_id' => '16',
            'Departamento_id' => '1',
            'jefes_areas_id' => '1',
        ]);

        PerfilesUsuarios::create([
            'IdUser' => '1',
            'IdEmp' => '5310',
            'Empresa' => 'SERGES',
            'Nombre' => 'ADMINISTRADOR',
            'ApPat' => 'PATERNO',
            'ApMat' => 'MATERNO',
            'Curp' => 'CURP',
            'Rfc' => 'RFC',
            'Nss' => 'NSS',
            'Direccion' => 'FFGFGDFGDFGFD',
            'Telefono' => '21231561',
            'Cumpleaños' => '2010-07-09',
            'FecIng' => '2010-07-09',
            'Antiguedad' => '25',
            'DiasVac' => '12',
            'Puesto_id' => '13',
            'user_id' => '1',
            'Departamento_id' => '1',
            'jefes_areas_id' => '21',
        ]);
    }
}
