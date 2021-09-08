<?php

namespace Database\Seeders;

use App\Models\Compras\Proveedores;
use Illuminate\Database\Seeder;

class ProveedoresSeeder extends Seeder
{
    public function run(){
        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'MAQUINADOS MEYADO',
            'Departamento' => 'COMPRAS',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'SEDICO',
            'Departamento' => 'COMPRAS',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'ESIME',
            'Departamento' => 'COMPRAS',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'ROBERTO MORA',
            'Departamento' => 'APERTURA',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'ADRIAN JUAREZ',
            'Departamento' => 'APERTURA',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'RILSA 2000 SA DE C',
            'Departamento' => 'APERTURA',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'TALLER ESPINOZA',
            'Departamento' => 'APERTURA',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'GASOLINERA PEMEX',
            'Departamento' => 'APERTURA',
            'TipoPago' => 'REMISION',
        ]);
    }
}
