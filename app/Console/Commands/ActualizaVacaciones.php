<?php

namespace App\Console\Commands;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class ActualizaVacaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea programada para actualizar los dias de vacaciones';

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
    public function handle(){

        $date = Carbon::now();
        $aniv = $date->format('m-d');

        $vacaciones = PerfilesUsuarios::get(['IdEmp', 'FecIng', 'Antiguedad', 'DiasVac']);

        foreach ($vacaciones as  $value) {

            //Conversion de fecha de ingreso a formato de Carbon
            $FechaIngreso = Carbon::parse($value->FecIng);
            $Antiguedad = Carbon::now()->diffInYears($FechaIngreso); //saco la diferencia de años
            $Aniversario = $FechaIngreso->format('m-d'); //obtengo el dia y el mes de aniversario
            //Calculos de años de antiguedad y dias de vacaciones correspondientes a cada año
            if($aniv == $Aniversario){ //Verifico dia del mes sea igual a dia que entro la persona
                //Actualizo los años de antiguedad
                PerfilesUsuarios::where('IdEmp', $value->IdEmp)->update(['Antiguedad' => $Antiguedad]);

                //Calulo los dias de vaciones correspondientes a la antiguedad
                if($Antiguedad <= 5){
                    switch ($Antiguedad) {
                        case 1:
                            $DiasVac = 6;
                            break;
                        case 2:
                            $DiasVac = 8;
                            break;
                        case 3:
                            $DiasVac = 10;
                            break;
                        case 4:
                            $DiasVac = 12;
                            break;
                        case 5:
                            $DiasVac = 14;
                            break;
                    }
                }else{
                    if($Antiguedad >= 6 && $Antiguedad <=9){
                        $DiasVac = 14;
                    }elseif($Antiguedad >= 10 && $Antiguedad <=14){
                        $DiasVac = 16;
                    }elseif($Antiguedad >= 15 && $Antiguedad <=19){
                        $DiasVac = 18;
                    }elseif($Antiguedad >= 20 && $Antiguedad <=24){
                        $DiasVac = 20;
                    }elseif($Antiguedad >= 25 && $Antiguedad <=29){
                        $DiasVac = 22;
                    }elseif($Antiguedad >= 30 && $Antiguedad <=34){
                        $DiasVac = 24;
                    }
                }
                //Actualizo los dias de vacaciones que corresponden
                PerfilesUsuarios::where('IdEmp', $value->IdEmp)->update(['DiasVac' => $DiasVac]);
            }
        }

        $texto = "[".date('Y-m-d: H:i:s')."]: Actualizacion de Dias de vacaciones";

        //Storage::disk('local')->put('archivo.txt', $texto);
        // Storage::disk('local')->append('archivo.txt', $texto, null);
        // Storage::append("archivo.txt", $texto);
    }
}
