<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'IdEmp' => '5310',
            'name' => 'DEVELOPER',
            'Area' => 'ADMINISTRADOR',
            'email' => 'desarrollador@intranethlangeles.com',
            'password' => bcrypt('1234')
        ])->assignRole('ONEPIECE');

        User::create([
            'IdEmp' => '10000',
            'name' => 'DEVELOPER 2',
            'Area' => 'ADMINISTRADOR',
            'email' => 'desarrollador2@intranethlangeles.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '10001',
            'name' => 'TESTER',
            'Area' => 'ADMINISTRADOR',
            'email' => 'tester@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '10002',
            'name' => 'Recursos Humanos',
            'Area' => 'RECURSOS HUMANOS',
            'email' => 'rh@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('RecursosHumanos');

        User::create([
            'IdEmp' => '10003',
            'name' => 'Almacen',
            'Area' => 'ALMACEN',
            'email' => 'almacen@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Almacen');

        User::create([
            'IdEmp' => '10004',
            'name' => 'Compras',
            'Area' => 'COMPRAS',
            'email' => 'compras@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Compras');

        User::create([
            'IdEmp' => '10005',
            'name' => 'Sistemas',
            'Area' => 'SISTEMAS',
            'email' => 'sistemas@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Sistemas');

        User::create([
            'IdEmp' => '10006',
            'name' => 'Direccion',
            'Area' => 'Direccion',
            'email' => 'Direccion@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Direccion');

        User::create([
            'IdEmp' => '10007',
            'name' => 'Contabilidad',
            'Area' => 'Contabilidad',
            'email' => 'Contabilidad@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Contabilidad');

        User::create([
            'IdEmp' => '10008',
            'name' => 'Contabilidad',
            'Area' => 'Contabilidad',
            'email' => 'Produccion@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Produccion');

        User::create([
            'IdEmp' => '10009',
            'name' => 'AREA X',
            'Area' => 'AREA X',
            'email' => 'area@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Produccion');

        User::create([
            'IdEmp' => '74',
            'name' => 'OSIRIS HERNANDEZ PEREZ',
            'Area' => 'Administrador',
            'email' => 'programador@hlangeles.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '28',
            'name' => 'JUAN PABLO QUINTANA',
            'Area' => 'SUPPLY',
            'email' => 'jpquintana@hlangeles.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '32',
            'name' => 'RICARDO ',
            'Area' => 'SISTEMAS',
            'email' => 'sistemas@hlangeles.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '13',
            'name' => 'LEYDEN LOPEZ SILVA ',
            'Area' => 'RECURSOS HUMANOS',
            'email' => 'rhumanos@hlangeles.com',
            'password' => bcrypt('12345678')
        ])->assignRole('RecursosHumanos');
        User::create([
            'IdEmp' => '78',
            'name' => 'Kevin Cisneros Ramirez',
            'Area' => 'ANILII',
            'email' => 'programador2@hlangeles.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Produccion');
    }
}
