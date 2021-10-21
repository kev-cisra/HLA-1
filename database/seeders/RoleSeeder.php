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
        $coordinador = Role::create(['name' => 'Cordinador']);
        $encargado = Role::create(['name' => 'Encargado']);
        $lider = Role::create(['name' => 'Lider']);
        $operador = Role::create(['name' => 'Operador']);

        Permission::create(['name' => 'admin.index'])->syncRoles([$ONEPIECE, $AdminRole]);
        Permission::create(['name' => 'RecursosHumanos.index'])->syncRoles([$ONEPIECE, $RHRole]);
        Permission::create(['name' => 'Sistemas.index'])->syncRoles([$ONEPIECE, $SistemasRole]);
        Permission::create(['name' => 'Almacen.index'])->syncRoles([$ONEPIECE, $AlmacenRole]);
        Permission::create(['name' => 'Compras.index'])->syncRoles([$ONEPIECE, $ComprasRole]);
        Permission::create(['name' => 'Contabilidad.index'])->syncRoles([$ONEPIECE, $ContabilidadRole]);
        Permission::create(['name' => 'Direccion.index'])->syncRoles([$ONEPIECE, $DireccionRole]);
        Permission::create(['name' => 'Produccion.index'])->syncRoles([$ONEPIECE, $ProduccionRole, $AdminRole]);
        Permission::create(['name' => 'Supply.index'])->syncRoles([$ONEPIECE, $SupplyRole]);
        //permisos modulos de produccion
        Permission::create(['name' => 'Produccion.personal.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole, $encargado]);
        Permission::create(['name' => 'Produccion.procesos.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole]);
        Permission::create(['name' => 'Produccion.maquinas.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole]);
        Permission::create(['name' => 'Produccion.turnos.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole, $encargado]);
        Permission::create(['name' => 'Produccion.materiales.index'])->syncRoles([$ONEPIECE, $SistemasRole]);
        Permission::create(['name' => 'Produccion.clamat.index'])->syncRoles([$ONEPIECE, $SistemasRole]);
        //permisos para carga
        Permission::create(['name' => 'Produccion.carga.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole, $encargado, $lider, $operador]);

        Permission::create(['name' => 'Produccion.paros.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole, $encargado, $lider, $operador]);

        Permission::create(['name' => 'Produccion.reporpro.index'])->syncRoles([$ONEPIECE, $coordinador, $SistemasRole, $encargado]);


        //Permisos especificos en cada menu
    }
}
