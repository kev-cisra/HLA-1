<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ONEPIECE  = Role::create(['name' => 'ONEPIECE']);
        $AdminRole  = Role::create(['name' => 'Administrador']);
        $RHRole  = Role::create(['name' => 'RecursosHumanos']);
        $SistemasRole  = Role::create(['name' => 'Sistemas']);
        $AlmacenRole  = Role::create(['name' => 'Almacen']);
        $ComprasRole  = Role::create(['name' => 'Compras']);
        $ContabilidadRole  = Role::create(['name' => 'Contabilidad']);
        $DireccionRole  = Role::create(['name' => 'Direccion']);
        $ProduccionRole  = Role::create(['name' => 'Produccion']);
        $SupplyRole  = Role::create(['name' => 'Supply']);
        $VisitanteRole  = Role::create(['name' => 'Visitante']);

        Permission::create(['name' => 'admin.index'])->syncRoles([$ONEPIECE, $AdminRole]);
        Permission::create(['name' => 'RecursosHumanos.index'])->syncRoles([$ONEPIECE, $RHRole]);
        Permission::create(['name' => 'Sistemas.index'])->syncRoles([$ONEPIECE, $SistemasRole]);
        Permission::create(['name' => 'Almacen.index'])->syncRoles([$ONEPIECE, $AlmacenRole]);
        Permission::create(['name' => 'Compras.index'])->syncRoles([$ONEPIECE, $ComprasRole]);
        Permission::create(['name' => 'Contabilidad.index'])->syncRoles([$ONEPIECE, $ContabilidadRole]);
        Permission::create(['name' => 'Direccion.index'])->syncRoles([$ONEPIECE, $DireccionRole]);
        Permission::create(['name' => 'Produccion.index'])->syncRoles($ONEPIECE, [$ProduccionRole]);
        Permission::create(['name' => 'Supply.index'])->syncRoles([$ONEPIECE, $SupplyRole]);

        //Permisos especificos en cada menu
    }
}
