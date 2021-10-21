<?php

namespace Database\Seeders;

use App\Models\Produccion\equipos;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        equipos::create(['nombre' => 'Equipo 1', 'turno_id' => 3, 'departamento_id' => 7]);
        equipos::create(['nombre' => 'Equipo 2', 'turno_id' => 3, 'departamento_id' => 7]);
        equipos::create(['nombre' => 'Equipo 3', 'turno_id' => 3, 'departamento_id' => 7]);
    }
}
