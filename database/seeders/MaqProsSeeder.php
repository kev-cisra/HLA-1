<?php

namespace Database\Seeders;

use App\Models\Produccion\maq_pro;
use Illuminate\Database\Seeder;

class MaqProsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        maq_pro::create([
            'proceso_id' => 5,
            'maquina_id' => 17
        ]);
        maq_pro::create([
            'proceso_id' => 6,
            'maquina_id' => 2
        ]);
        maq_pro::create([
            'proceso_id' => 8,
            'maquina_id' => 6
        ]);
        maq_pro::create([
            'proceso_id' => 9,
            'maquina_id' => 3
        ]);
        maq_pro::create([
            'proceso_id' => 12,
            'maquina_id' => 10
        ]);
        maq_pro::create([
            'proceso_id' => 16,
            'maquina_id' => 17
        ]);
        maq_pro::create([
            'proceso_id' => 17,
            'maquina_id' => 2
        ]);
        maq_pro::create([
            'proceso_id' => 19,
            'maquina_id' => 6
        ]);
        maq_pro::create([
            'proceso_id' => 20,
            'maquina_id' => 3
        ]);
        maq_pro::create([
            'proceso_id' => 22,
            'maquina_id' => 10
        ]);
        maq_pro::create([
            'proceso_id' => 7,
            'maquina_id' => 1
        ]);
        maq_pro::create([
            'proceso_id' => 13,
            'maquina_id' => 1
        ]);
        maq_pro::create([
            'proceso_id' => 10,
            'maquina_id' => 5
        ]);

    }
}
