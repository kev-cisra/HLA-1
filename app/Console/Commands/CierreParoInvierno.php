<?php

namespace App\Console\Commands;

use App\Models\Produccion\parosCarga;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CierreParoInvierno extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cierre:paroInvierno';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierre de los paros por turno invierno';

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
        $up = '';
        $txt = '';
        //$hoy->toDateTimeString();

        if (!var_dump($hoy->isDST())) {
            $txt = 'entro a paro '.$hoy.' -> ';
            $paros = parosCarga::where('departamento_id', '=', 7)
            ->where('estatus', '=', 'Activo')
            ->get();
            foreach ($paros as $paro) {
                $tiempo = $hoy->diffInMinutes($paro->fecha);
                if (empty($paro->paros_carga_id)) {
                    parosCarga::create([
                        'fecha' => $hoy->toDateTimeString(),
                        'iniFecha' => $paro->iniFecha,
                        'paro_id' => $paro->paro_id,
                        'estatus' => 'Activo',
                        'perfil_ini_id' => $paro->perfil_ini_id,
                        'maq_pro_id' => $paro->maq_pro_id,
                        'proceso_id' => $paro->proceso_id,
                        'orden' => $paro->orden,
                        'VerInv' => $paro->VerInv,
                        'descri' => $paro->descri,
                        'paros_carga_id' => $paro->id,
                        'departamento_id' => $paro->departamento_id
                    ]);
                    $up .= parosCarga::find($paro->id)->update(['finFecha' => $hoy->toDateTimeString(), 'tiempo' => $tiempo, 'estatus' => 'Autorizado', 'nota' => 'se mantiene activo', 'perfil_fin_id' => 7]);
                }else{
                    //$txt.='entro sub paro '.$hoy.' || ';
                    $parUp = parosCarga::where('paros_carga_id', '=', $paro->paros_carga_id)->orderBy('id', 'desc')->first();
                    parosCarga::create([
                        'fecha' => $hoy->toDateTimeString(),
                        'iniFecha' => $parUp->iniFecha,
                        'paro_id' => $parUp->paro_id,
                        'estatus' => $parUp->estatus,
                        'perfil_ini_id' => $parUp->perfil_ini_id,
                        'maq_pro_id' => $parUp->maq_pro_id,
                        'proceso_id' => $parUp->proceso_id,
                        'orden' => $parUp->orden,
                        'VerInv' => $parUp->VerInv,
                        'descri' => $parUp->descri,
                        'paros_carga_id' => $paro->paros_carga_id,
                        'departamento_id' => $parUp->departamento_id
                    ]);
                    $up = parosCarga::find($parUp->id)->update(['finFecha' => $hoy->toDateTimeString(), 'tiempo' => $tiempo, 'estatus' => 'Autorizado', 'nota' => 'se mantiene activo', 'perfil_fin_id' => 7]);
                }
                //$txt.= 'entro normal '.$up->id.' || ';
            }
        }

        //Storage::disk('local')->put('paroInvierno.txt', $txt);
        return Command::SUCCESS;
    }
}
