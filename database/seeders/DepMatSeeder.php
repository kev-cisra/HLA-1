<?php

namespace Database\Seeders;

use App\Models\Produccion\dep_mat;
use Illuminate\Database\Seeder;

class DepMatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        dep_mat::create(['departamento_id' => 7, 'material_id' => 6]);
        dep_mat::create(['departamento_id' => 7, 'material_id' =>  31]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 32]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 33]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 34]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 35]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 36]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 37]);
        dep_mat::create(['departamento_id' => 7, 'material_id' => 2]);
    }
}
