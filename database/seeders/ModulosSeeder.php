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

        // *****************ADMINISTRADOR *******************



        // ************ PRODUCCCION *******************
        Modulos::create([
            'Iduser' => '16',
            'NombreModulo' => 'PERSONAL',
            'Icono' => 'fas fa-users',
            'Ruta' => 'Produccion/Personal',
            'Area' => '7',
        ]);

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


        ///////////// RECURSOS HUMANOS ////////////////////

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
            'NombreModulo' => 'CANCELA VACACIONES',
            'Icono' => 'fas fa-file-signature',
            'Ruta' => 'RecursosHumanos/CancelaVacaciones',
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

        ///////////////// Compras ///////////////////
        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'PROVEEDORES',
            'Icono' => 'fas fa-truck',
            'Ruta' => 'Compras/Proveedores',
            'Area' => '4',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'COTIZACIONES',
            'Icono' => 'fas fa-calculator',
            'Ruta' => 'Compras/Cotizaciones',
            'Area' => '4',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'PAPELERIA',
            'Icono' => 'fas fa-store',
            'Ruta' => 'Compras/Papeleria',
            'Area' => '4',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'ALTA PAPELERIA',
            'Icono' => 'fas fa-pencil-alt',
            'Ruta' => 'Compras/AltaPapeleria',
            'Area' => '4',
        ]);


        ////////////// ALMACEN ////////////////////////

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'REQUISICIONES SOLICITADAS',
            'Icono' => 'fas fa-clipboard-list',
            'Ruta' => 'Almacen/Requisiciones',
            'Area' => '3',
        ]);


        ////////////////////// SUPPLY /////////////////////////


        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'AUTORIZA REQUISICIONES',
            'Icono' => 'fas fa-stamp',
            'Ruta' => 'Supply/AutorizaRequisiciones',
            'Area' => '8',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'PRESUPUESTOS',
            'Icono' => 'fas fa-coins',
            'Ruta' => 'Supply/Presupuestos',
            'Area' => '8',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'GASTOS REQUISICIONES',
            'Icono' => 'fas fa-cash-register',
            'Ruta' => 'Supply/GastosRequisiciones',
            'Area' => '8',
        ]);

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'INSUMOS SOLICITADOS',
            'Icono' => 'fas fa-clipboard-check',
            'Ruta' => 'Supply/InsumosSolicitados',
            'Area' => '8',
        ]);


        ////////////// PRODUCCCION ///////////////////

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

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'CARGA DE DATOS',
            'Icono' => 'fas fa-clipboard-list',
            'Ruta' => 'Produccion/Carga',
            'Area' => '7',
        ]);

        ///////////// CONTABILIDAD ///////////////////
        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'COSTOS EMPAQUES',
            'Icono' => 'fas fa-boxes',
            'Ruta' => 'Contabilidad/CostosEmpaques',
            'Area' => '5',
        ]);

        ////////////// DIRECCION ///////////////////

        Modulos::create([
            'Iduser' => '1',
            'NombreModulo' => 'CALCULADORA TORCIONES',
            'Icono' => 'fas fa-calculator',
            'Ruta' => 'Direccion/CalculadoraTorciones',
            'Area' => '6',
        ]);
    }
}
