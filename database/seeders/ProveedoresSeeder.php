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
            'Departamentos_id' => '14',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'SEDICO',
            'Departamentos_id' => '14',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'ESIME',
            'Departamentos_id' => '14',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'ROBERTO MORA',
            'Departamentos_id' => '7',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'ADRIAN JUAREZ',
            'Departamentos_id' => '7',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'RILSA 2000 SA DE C',
            'Departamentos_id' => '7',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'TALLER ESPINOZA',
            'Departamentos_id' => '7',
            'TipoPago' => 'REMISION',
        ]);

        Proveedores::create([
            'IdUser' => 18,
            'Nombre' => 'GASOLINERA PEMEX',
            'Departamentos_id' => '7',
            'TipoPago' => 'REMISION',
        ]);

    }
}
