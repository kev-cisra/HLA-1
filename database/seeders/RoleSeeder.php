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
        //Produccion modulos
        /* $ProPersoRole = Role::create(['name' => 'Produccion/Personal']);
        $ProProceRole = Role::create(['name' => 'Produccion/Procesos']);
        $ProMaquiRole = Role::create(['name' => 'Produccion/Maquinas']);
        $ProTurnoRole = Role::create(['name' => 'Produccion/Turnos']);
        $ProMaterRole = Role::create(['name' => 'Produccion/Materiales']);
        $ProClaveRole = Role::create(['name' => 'Produccion/Clamat']);
        $ProCargaRole = Role::create(['name' => 'Produccion/Carga']); */

        Permission::create(['name' => 'admin.index'])->syncRoles([$ONEPIECE, $AdminRole]);
        Permission::create(['name' => 'RecursosHumanos.index'])->syncRoles([$ONEPIECE, $RHRole]);
        Permission::create(['name' => 'Sistemas.index'])->syncRoles([$ONEPIECE, $SistemasRole]);
        Permission::create(['name' => 'Almacen.index'])->syncRoles([$ONEPIECE, $AlmacenRole]);
        Permission::create(['name' => 'Compras.index'])->syncRoles([$ONEPIECE, $ComprasRole]);
        Permission::create(['name' => 'Contabilidad.index'])->syncRoles([$ONEPIECE, $ContabilidadRole]);
        Permission::create(['name' => 'Direccion.index'])->syncRoles([$ONEPIECE, $DireccionRole]);
        Permission::create(['name' => 'Produccion.index'])->syncRoles([$ONEPIECE, $ProduccionRole]);
        Permission::create(['name' => 'Supply.index'])->syncRoles([$ONEPIECE, $SupplyRole]);
        //permisos modulos de produccion
        /* Permission::create(['name' => 'Personal.index'])->syncRoles([$ONEPIECE, $ProPersoRole, $SistemasRole]);
        Permission::create(['name' => 'Procesos.index'])->syncRoles([$ONEPIECE, $ProProceRole, $SistemasRole]);
        Permission::create(['name' => 'Maquinas.index'])->syncRoles([$ONEPIECE, $ProMaquiRole, $SistemasRole]);
        Permission::create(['name' => 'Turnos.index'])->syncRoles([$ONEPIECE, $ProTurnoRole, $SistemasRole]);
        Permission::create(['name' => 'Materiales.index'])->syncRoles([$ONEPIECE, $ProMaterRole, $SistemasRole]);
        Permission::create(['name' => 'Clamat.index'])->syncRoles([$ONEPIECE, $ProClaveRole, $SistemasRole]);
        Permission::create(['name' => 'Carga.index'])->syncRoles([$ONEPIECE, $ProCargaRole, $SistemasRole]); */


        //Permisos especificos en cada menu
    }
}
