<?php

namespace Database\Seeders;

use App\Models\Produccion\turnos;
use Illuminate\Database\Seeder;

class TurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Apertura
        turnos::create([
            'nomtur' => 'Turno 1',
            'LVIni' => '09:00',
            'LVFin' => '20:00',
            'SDIni' => '09:00',
            'SDFin' => '21:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 7
        ]);
        turnos::create([
            'nomtur' => 'Turno 2',
            'LVIni' => '22:00',
            'LVFin' => '09:00',
            'SDIni' => '21:00',
            'SDFin' => '09:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 7
        ]);
        turnos::create([
            'nomtur' => 'Vacío',
            'LVIni' => '00:00',
            'LVFin' => '00:00',
            'SDIni' => '00:00',
            'SDFin' => '00:00',
            'cargaExt' => '00',
            'VerInv' => '-',
            'departamento_id' => 7
        ]);
        //Anillo
        turnos::create([
            'nomtur' => 'Turno 1',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 8
        ]);
        turnos::create([
            'nomtur' => 'Turno 2',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 8
        ]);
        turnos::create([
            'nomtur' => 'Vacío',
            'LVIni' => '00:00',
            'LVFin' => '00:00',
            'SDIni' => '00:00',
            'SDFin' => '00:00',
            'cargaExt' => '00',
            'VerInv' => '-',
            'departamento_id' => 8
        ]);
        //hilatura 1
        turnos::create([
            'nomtur' => 'Turno 1',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 4
        ]);
        turnos::create([
            'nomtur' => 'Turno 2',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 4
        ]);
        turnos::create([
            'nomtur' => 'Vacío',
            'LVIni' => '00:00',
            'LVFin' => '00:00',
            'SDIni' => '00:00',
            'SDFin' => '00:00',
            'cargaExt' => '00',
            'VerInv' => '-',
            'departamento_id' => 4
        ]);
        //hilatura 2
        turnos::create([
            'nomtur' => 'Turno 1',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 5
        ]);
        turnos::create([
            'nomtur' => 'Turno 2',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 5
        ]);
        turnos::create([
            'nomtur' => 'Vacío',
            'LVIni' => '00:00',
            'LVFin' => '00:00',
            'SDIni' => '00:00',
            'SDFin' => '00:00',
            'cargaExt' => '00',
            'VerInv' => '-',
            'departamento_id' => 5
        ]);
        //hilatura 3
        turnos::create([
            'nomtur' => 'Turno 1',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 6
        ]);
        turnos::create([
            'nomtur' => 'Turno 2',
            'LVIni' => '07:00',
            'LVFin' => '19:00',
            'SDIni' => '07:00',
            'SDFin' => '19:00',
            'cargaExt' => '30',
            'VerInv' => 'Verano',
            'departamento_id' => 6
        ]);
        turnos::create([
            'nomtur' => 'Vacío',
            'LVIni' => '00:00',
            'LVFin' => '00:00',
            'SDIni' => '00:00',
            'SDFin' => '00:00',
            'cargaExt' => '00',
            'VerInv' => '-',
            'departamento_id' => 6
        ]);
    }
}
