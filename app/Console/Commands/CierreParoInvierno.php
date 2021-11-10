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
        //$hoy->toDateTimeString();

        if (!var_dump($hoy->isDST())) {
            $txt = '';
            $paros = parosCarga::where('departamento_id', '=', 7)
            ->where('estatus', '=', 'Activo')
            ->get();
            foreach ($paros as $paro) {
                $tiempo = $hoy->diffInMinutes($paro->iniFecha);
                if (empty($paro->paros_carga_id)) {
                    $txt.='entro normal '.$hoy.' || ';
                    parosCarga::create([
                        'fecha' => $paro['fecha'],
                        'iniFecha' => $hoy,
                        'paro_id' => $paro['paro_id'],
                        'estatus' => $paro['estatus'],
                        'perfil_ini_id' => $paro['usu'],
                        'maq_pro_id' => $paro['maq_pro_id'],
                        'proceso_id' => $paro['proceso_id'],
                        'orden' => $paro['orden'],
                        'VerInv' => $paro['VerInv'],
                        'descri' => $paro['descri'],
                        'departamento_id' => $paro['departamento_id']
                    ]);
                    parosCarga::find($paro->id)->update(['finFecha' => $hoy, 'tiempo' => $tiempo, 'estatus' => 'Autorizado', 'nota' => 'se mantiene activo', 'perfil_fin_id' => 2]);
                }else{
                    $txt.='entro sub paro '.$hoy.' || ';
                    $parUp = parosCarga::find($paro->paros_carga_id);
                    parosCarga::create([
                        'fecha' => $parUp['fecha'],
                        'iniFecha' => $hoy,
                        'paro_id' => $parUp['paro_id'],
                        'estatus' => $parUp['estatus'],
                        'perfil_ini_id' => $parUp['usu'],
                        'maq_pro_id' => $parUp['maq_pro_id'],
                        'proceso_id' => $parUp['proceso_id'],
                        'orden' => $parUp['orden'],
                        'VerInv' => $parUp['VerInv'],
                        'descri' => $parUp['descri'],
                        'paros_carga_id' => $paro->paros_carga_id,
                        'departamento_id' => $parUp['departamento_id']
                    ]);
                    parosCarga::find($paro->id)->update(['finFecha' => $hoy, 'tiempo' => $tiempo, 'estatus' => 'Autorizado', 'nota' => 'se mantiene activo', 'perfil_fin_id' => 2]);
                }
            }

        }

        Storage::disk('local')->put('paroInvierno.txt', $txt);
        return Command::SUCCESS;
    }
}
