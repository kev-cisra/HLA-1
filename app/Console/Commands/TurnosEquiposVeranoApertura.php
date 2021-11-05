<?php

namespace App\Console\Commands;

use App\Models\Produccion\equipos;
use App\Models\Produccion\turnos;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TurnosEquiposVeranoApertura extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Verano:Equipos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambio de turno y equipos en apertura verano';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

       //Pone la fecha de hoy
        $hoy = Carbon::now();

        $txt = 'si entro '.$hoy;
        //verifica si estamos en invierno
        if(var_dump($hoy->isDST())){
            $txt += ' entro a verano';
            //se consulta turnos y los equipos
            $turnos = turnos::where('departamento_id', '=', 7)
            ->with([
                'equipos' => function($eq){
                    $eq->select('id', 'nombre', 'turno_id', 'cue_dia', 'max_dia', 'departamento_id');
                }
            ])
            ->get(['id', 'nomtur', 'departamento_id']);

            //se hace el recorrido de los turnos
            foreach ($turnos as $tur) {
                //si existe algun dato en el equipo
                if(count($tur->equipos) != 0){
                    foreach ($tur->equipos as $equi) {
                        if(!empty($equi->max_dia)){
                            if($tur->nomtur == 'Turno 1'){
                                $cuenta = $equi->cue_dia+1;
                                if($cuenta <= $equi->max_dia){
                                    equipos::find($equi->id)->update(['cue_dia' => $cuenta]);
                                }else{
                                    $idtur = turnos::where('departamento_id', '=', 7)->where('nomtur', '=', 'Vacío')->first();
                                    equipos::find($equi->id)->update(['cue_dia' => 1, 'max_dia' => 2, 'turno_id' => $idtur->id]);
                                }
                            }elseif($tur->nomtur == 'Turno 2'){
                                $cuenta = $equi->cue_dia+1;
                                if($cuenta <= $equi->max_dia){
                                    equipos::find($equi->id)->update(['cue_dia' => $cuenta]);
                                }else{
                                    $idtur = turnos::where('departamento_id', '=', 7)->where('nomtur', '=', 'Vacío')->first();
                                    equipos::find($equi->id)->update(['cue_dia' => 1, 'max_dia' => 3, 'turno_id' => $idtur->id]);
                                }
                            }else{
                                $cuenta = $equi->cue_dia+1;
                                if($cuenta <= $equi->max_dia){
                                    equipos::find($equi->id)->update(['cue_dia' => $cuenta]);
                                }else{
                                    if ($equi->max_dia == 2) {
                                        $nomtur = 'Turno 2';
                                    }else{
                                        $nomtur = 'Turno 1';
                                    }
                                    $idtur = turnos::where('departamento_id', '=', 7)->where('nomtur', '=', $nomtur)->first();
                                    equipos::find($equi->id)->update(['cue_dia' => 1, 'max_dia' => 5, 'turno_id' => $idtur->id]);
                                }
                            }
                        }
                    }
                }
            }

        }
        Storage::disk('local')->put('prueba.txt', $txt);
        return Command::SUCCESS;
    }
}
