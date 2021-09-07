<?php

namespace Database\Seeders;

use App\Models\Produccion\catalogos\materiales;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        materiales::create([
            'idmat' => 'KVT',
            'nommat' => 'KEVLAR T'
        ]);
        materiales::create([
            'idmat' => 'KVR',
            'nommat' => 'KEVLAR'
        ]);
        materiales::create([
            'idmat' => 'BKV',
            'nommat' => 'BLEND KEVLAR'
        ]);
        materiales::create([
            'idmat' => 'POL',
            'nommat' => 'POLIESTER'
        ]);
        materiales::create([
            'idmat' => 'NOM',
            'nommat' => 'NOMEX'
        ]);
        materiales::create([
            'idmat' => 'ACR',
            'nommat' => 'ACRILICO'
        ]);
        materiales::create([
            'idmat' => 'CO',
            'nommat' => 'ALGODÓN'
        ]);
        materiales::create([
            'idmat' => 'NYL',
            'nommat' => 'NYLON'
        ]);
        materiales::create([
            'idmat' => '7DPA',
            'nommat' => 'DESARROLLO PUREBAS ANILLO'
        ]);
    }
}
