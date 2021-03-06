<?php

namespace App\Http\Controllers\Produccion\Calculos;

use App\Http\Controllers\Controller;
use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\turnos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;

class CalculosController extends Controller
{
    //
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'fecha' => ['required'],
            'hoy' => ['required'],
            'mañana' => ['required'],
            'depa' => ['required']
        ])->validate();

        $usuario = Auth::id();
        $perf = PerfilesUsuarios::where('user_id','=',$usuario)
            ->first('id');
        //pone la hora de inicio y fin para consultar
        /* $hIni = ' 07:00:00';
        if ($request->depa == 7 & !empty(Carbon::createFromDate($request->fecha)->isDST())) {
            $hIni = ' 09:00:00';
        }else if($request->depa == 7 & empty(Carbon::createFromDate($request->fecha)->isDST())) {
            $hIni = ' 08:00:00';
        } */


        //dias para consultar
        $hoy = $request->hoy;
        $mañana = $request->mañana;
        $semana = date('Y',strtotime($request->fecha)).'-W'.date('W',strtotime($request->fecha));
        $fechas = ['fecha' => $request->fecha, 'hoy' => $hoy, 'mañana' => $mañana, 'semana' => $semana];

        $calcula = procesos::where('departamento_id', '=', $request->depa)
            ->where('tipo', '=', '3')
            ->orWhere('tipo', '=', '4')
            ->with([
                'formulas' => function($fo){
                    $fo -> select('id', 'proc_rela', 'maq_pros_id', 'proceso_id');
                },
                'formulas.proc_relas' => function($fp){
                    $fp -> select('id', 'nompro', 'tipo', 'proceso_id');
                }
            ])
            ->get(['id', 'nompro', 'tipo', 'operacion']);
        //muestra las operaciones
        foreach ($calcula as $ope) {
            //dependiendo del tipo de operacion
            switch ($ope->operacion) {
                case 'sm_d':
                    $this->sm_d($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sm_dc':
                    $this->sm_dc($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sm_dp':
                    $this->sm_dp($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sm_t':
                    $this->sm_t($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sm_tc':
                    $this->sm_tc($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sm_tp':
                    $this->sm_tp($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sem_sm':
                    $this->sem_sm($ope, $request->depa, $fechas, $perf);
                    break;
                case 'mes_sm':
                    $this->mes_sm($ope, $request->depa, $fechas, $perf);
                    break;
                case 'efi_dia':
                    $this->efi_dia($ope, $request->depa, $fechas, $perf);
                    break;
                case 'efi_cla':
                    $this->efi_cla($ope, $request->depa, $fechas, $perf);
                    break;
                case 'efi_sem':
                    $this->efi_sem($ope, $request->depa, $fechas, $perf);
                    break;
                case 'efi_pun_dia':
                    $this->efi_pun_dia($ope, $request->depa, $fechas, $perf);
                    break;
                /* case 'efi_pun_sem':
                    $this->efi_pun_sem($ope, $request->depa, $fechas, $perf);
                    break;
                case 'efi_pun_mes':
                    $this->efi_pun_mes($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sm_pun_d':
                    $this->sm_pun_d($ope, $request->depa, $fechas, $perf);
                    break;
                case 'sem_pun_sm':
                    $this->sem_pun_sm($ope, $request->depa, $fechas, $perf);
                    break;
                case 'mes_pun_sm':
                    $this->mes_pun_sm($ope, $request->depa, $fechas, $perf);
                    break; */
            }
        }

        //return 'Listo';

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }
    /************************************** Guardado o Actualizado ************************************/
    public function gua_act($fec, $data){
        //consulta si existe el dato
        $inicio = $fec['fecha'].' 12:50:00';
        $fin = $fec['fecha'].' 13:10:00';
        $existe = carga::whereBetween('fecha', [$inicio, $fin])
            ->where('proceso_id', '=', $data['proceso_id'])
            ->where('clave_id', '=', $data['clave_id'])
            ->where('turno_id', '=', $data['turno_id'])
            ->where('partida', '=', $data['partida'])
            ->first();
        if (empty($existe)) {
            carga::create([
                'fecha' => $fec['fecha'].' 13:00:00',
                'semana' => $fec['semana'],
                'partida' => $data['partida'],
                'valor' => $data['suma'],
                'equipo_id' => $data['equipo_id'],
                'notaPen' => '1',
                'estatus' => '1',
                'VerInv' => $data['cantidad'],
                'per_carga' => $data['per_carga'],
                'proceso_id' => $data['proceso_id'],
                'norma' => $data['norma'],
                'clave_id' => $data['clave_id'],
                'turno_id' => $data['turno_id'],
                'departamento_id' => $data['departamento_id'],
                'partida_id' => $data['partida_id']
            ]);
        }else {
            carga::find($existe->id)->update([
                'partida' => $data['partida'],
                'valor' => $data['suma'],
                'VerInv' => $data['cantidad'],
                'per_carga' => $data['per_carga'],
                'proceso_id' => $data['proceso_id'],
                'norma' => $data['norma'],
                'clave_id' => $data['clave_id'],
                'turno_id' => $data['turno_id'],
                'partida_id' => $data['partida_id']
            ]);
        }
    }

    public function gua_act_sem($fec, $data){
        //consulta si existe el dato
        $inicio = date("Y", strtotime($fec['fecha'])).'-W'.date("W", strtotime($fec['fecha']));
        $existe = carga::where('semana', '=', $inicio)
            ->where('proceso_id', '=', $data['proceso_id'])
            ->where('clave_id', '=', $data['clave_id'])
            ->where('turno_id', '=', $data['turno_id'])
            ->first();
        if (empty($existe)) {
            carga::create([
                'fecha' => $fec['fecha'].' 13:00:00',
                'semana' => $fec['semana'],
                'partida' => $data['partida'],
                'valor' => $data['suma'],
                'equipo_id' => $data['equipo_id'],
                'notaPen' => '1',
                'estatus' => '1',
                'VerInv' => $data['cantidad'],
                'per_carga' => $data['per_carga'],
                'proceso_id' => $data['proceso_id'],
                'norma' => $data['norma'],
                'clave_id' => $data['clave_id'],
                'turno_id' => $data['turno_id'],
                'departamento_id' => $data['departamento_id']
            ]);
        }else {
            carga::find($existe->id)->update([
                'partida' => $data['partida'],
                'valor' => $data['suma'],
                'VerInv' => $data['cantidad'],
                'per_carga' => $data['per_carga'],
                'proceso_id' => $data['proceso_id'],
                'norma' => $data['norma'],
                'clave_id' => $data['clave_id'],
                'turno_id' => $data['turno_id']
            ]);
        }
    }

    public function gua_act_mes($fec, $data){
        //consulta si existe el dato
        $inicio = date("Y-m", strtotime($fec['fecha']));
        $existe = carga::where('fecha', 'like', '%'.$inicio.'%')
            ->where('proceso_id', '=', $data['proceso_id'])
            ->where('clave_id', '=', $data['clave_id'])
            ->where('turno_id', '=', $data['turno_id'])
            ->first();
        if (empty($existe)) {
            carga::create([
                'fecha' => $fec['fecha'].' 13:00:00',
                'semana' => $fec['semana'],
                'partida' => $data['partida'],
                'valor' => $data['suma'],
                'equipo_id' => $data['equipo_id'],
                'notaPen' => '1',
                'estatus' => '1',
                'VerInv' => $data['cantidad'],
                'per_carga' => $data['per_carga'],
                'proceso_id' => $data['proceso_id'],
                'norma' => $data['norma'],
                'clave_id' => $data['clave_id'],
                'turno_id' => $data['turno_id'],
                'departamento_id' => $data['departamento_id']
            ]);
        }else {
            carga::find($existe->id)->update([
                'partida' => $data['partida'],
                'valor' => $data['suma'],
                'VerInv' => $data['cantidad'],
                'per_carga' => $data['per_carga'],
                'proceso_id' => $data['proceso_id'],
                'norma' => $data['norma'],
                'clave_id' => $data['clave_id'],
                'turno_id' => $data['turno_id']
            ]);
        }
    }
    /************************************** Operaciones ***********************************************/
    //operacion suma del dia
    public function sm_d($val, $dep, $fechas, $usuario){
        $fs = 0;
        $fc = 0;
        //recorrido de formulas
        foreach ($val->formulas as $value) {
            $proce_id = $value->proceso_id;
            //Consulta para la suma
            $suma = carga::where('departamento_id', '=', $dep)
                ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                ->where('maq_pro_id', '=', $value->maq_pros_id)
                ->sum('valor');

            //Consulta de paquetes contados
            $cuenta = carga::where('departamento_id', '=', $dep)
                ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                -> where('maq_pro_id', '=', $value->maq_pros_id)
                ->count('valor');

            //variablesde operaciones
            $fs += $suma;
            $fc += $cuenta;
            //print($fs.' | '.$cuenta.' / ');
        }
        $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => null, 'turno_id' => null, 'cantidad' => $fc, 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep, 'partida_id' => null];
        //echo $data['proceso_id'].' | '.$data['suma'].' | '.$data['cantidad'].'  fin suma dia || ';
        if ($fc != 0) {
            $this->gua_act($fechas, $data);
        }

        return 'sm_d';
    }

    //operacion suma dia clave
    public function sm_dc($val, $dep, $fechas, $usuario){
        $claves = carga::where('departamento_id', '=', $dep)
        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
        ->distinct()
        ->get(['norma','clave_id']);
        foreach ($claves as $cl) {
            if (!empty($cl->clave_id)) {
                //print($cl);

                $fs = 0;
                $fc = 0;
                //recorrido de formulas
                foreach ($val->formulas as $value) {
                    $proce_id = $value->proceso_id;
                    $maq_id = $value->maq_pros_id;

                    //suma
                    $suma = carga::where('departamento_id', '=', $dep)
                        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                        ->where('clave_id', '=', $cl->clave_id)
                        -> where('maq_pro_id', '=', $value->maq_pros_id)
                        ->sum('valor');

                    //catidad
                    $cuenta = carga::where('departamento_id', '=', $dep)
                        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                        ->where('clave_id', '=', $cl->clave_id)
                        -> where('maq_pro_id', '=', $value->maq_pros_id)
                        ->count('valor');
                    //resultado
                    $fs += $suma;
                    $fc += $cuenta;
                }
                $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => null, 'turno_id' => null, 'cantidad' => $fc, 'partida' => 'N/A', 'norma' => $cl->norma, 'clave_id' => $cl->clave_id, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id, 'partida_id' => null];
                if ($fc != 0) {
                    //print($val->nompro.' | '.$cl->clave->CVE_ART.' | '.$fs.' | '.$fc.' - ');
                    $this->gua_act($fechas, $data);
                }
            }

        }
        //echo ' fin suma clave dia || ';
        return 'sm_dc';

    }

    //operacion suma dia partida
    public function sm_dp($val, $dep, $fechas, $usuario){
        $partida = carga::where('departamento_id', '=', $dep)
        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
        ->distinct()
        ->get(['partida','norma','clave_id', 'partida_id']);
        foreach ($partida as $pr) {
            //print_r($pr['partida_id'].' /');
            if ($pr['partida'] != 'N/A') {
                # code...
                $fs = 0;
                $fc = 0;
                foreach ($val->formulas as $value){
                    $proce_id = $value->proceso_id;
                    $maq_id = $value->maq_pros_id;

                    //suma
                    $suma = carga::where('departamento_id', '=', $dep)
                        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                        ->where('partida', '=', $pr->partida)
                        ->where('clave_id', '=', $pr->clave_id)
                        -> where('maq_pro_id', '=', $value->maq_pros_id)
                        ->sum('valor');

                    //catidad
                    $cuenta = carga::where('departamento_id', '=', $dep)
                        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                        ->where('partida', '=', $pr->partida)
                        ->where('clave_id', '=', $pr->clave_id)
                        -> where('maq_pro_id', '=', $value->maq_pros_id)
                        ->count('valor');
                    //resultado
                    $fs += $suma;
                    $fc += $cuenta;
                }
                $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => null, 'turno_id' => null, 'cantidad' => $fc, 'partida' => $pr->partida, 'norma' => $pr->norma, 'clave_id' => $pr->clave_id, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id, 'partida_id' => $pr->partida_id];
                if ($fc != 0 & !empty($pr->partida_id)) {
                    //print_r($data);
                    $this->gua_act($fechas, $data);
                }
            }

        }
    }

    //operacion suma turno
    public function sm_t($val, $dep, $fechas, $usuario){
        //se consultan los turnos que existe menos el turno vacio
        $turnos = turnos::where('departamento_id', '=', $dep)
            ->with([
                'equipos'
            ])
            ->where('nomtur', '!=', 'Vacío')
            ->get();
        //recorrido del turno
        foreach ($turnos as $tur) {
            //variablesde operaciones
            $fs = 0;
            $fc = 0;
            //recorrido de formulas
            foreach ($val->formulas as $value) {
                $proce_id = $value->proceso_id;
                $maq_id = $value->maq_pros_id;

                //suma
                $suma = carga::where('departamento_id', '=', $dep)
                ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                ->where('turno_id', '=', $tur->id)
                -> where('maq_pro_id', '=', $value->maq_pros_id)
                ->sum('valor');

                //catidad
                $cuenta = carga::where('departamento_id', '=', $dep)
                ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                ->where('turno_id', '=', $tur->id)
                -> where('maq_pro_id', '=', $value->maq_pros_id)
                ->count('valor');

                //resultado
                $fs += $suma;
                $fc += $cuenta;
                //print( $val->nompro.' | '.$tur->nomtur.' | '.$fs.' | '.$fc.' / ');
                $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => $tur->equipos[0]->id, 'turno_id' => $tur->id, 'cantidad' => $fc, 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id, 'partida_id' => null];
                if ($fc != 0) {
                    $this->gua_act($fechas, $data);
                }
            }
            //echo $tur;
        }
        //echo 'Fin suma turno || ';
        return 'sm_t';
    }

    //operacion suma turno clave
    public function sm_tc($val, $dep, $fechas, $usuario){
        //se consultan los turnos que existe menos el turno vacio
        $turnos = turnos::where('departamento_id', '=', $dep)
        ->with([
            'equipos'
        ])
        ->where('nomtur', '!=', 'Vacío')
        ->get();
        //recorrido del turno
        foreach ($turnos as $tur) {
            //recorrido de formulas
            foreach ($val->formulas as $value) {
                $proce_id = $value->proceso_id;
                $maq_id = $value->maq_pros_id;
                //consulta
                $claves = carga::where('departamento_id', '=', $dep)
                    ->where('maq_pro_id', '=', $maq_id)
                    ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->with([
                        'clave' => function($cla){
                            $cla ->withTrashed()
                            -> select('id', 'CVE_ART', 'DESCR');
                        }
                    ])
                    ->distinct()
                    ->get(['clave_id', 'norma']);
                //recorrido de claves
                foreach ($claves as $cl) {
                    //variablesde operaciones
                    $fs = 0;
                    $fc = 0;
                    //suma
                    $suma = carga::where('departamento_id', '=', $dep)
                    ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->where('clave_id', '=', $cl->clave_id)
                    ->where('turno_id', '=', $tur->id)
                    -> where('maq_pro_id', '=', $value->maq_pros_id)
                    ->sum('valor');

                    //catidad
                    $cuenta = carga::where('departamento_id', '=', $dep)
                    ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    ->where('turno_id', '=', $tur->id)
                    ->where('clave_id', '=', $cl->clave_id)
                    -> where('maq_pro_id', '=', $value->maq_pros_id)
                    ->count('valor');

                    //resultado
                    $fs += $suma;
                    $fc += $cuenta;
                    $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => $tur->equipos[0]->id, 'turno_id' => $tur->id, 'cantidad' => $fc, 'partida' => 'N/A', 'norma' => $cl->norma, 'clave_id' => $cl->clave_id, 'per_carga' => $usuario->id, 'departamento_id' => $dep, 'maq_pro_id' => $maq_id, 'partida_id' => null];
                    if ($fc != 0) {
                        //print_r($data);
                        $this->gua_act($fechas, $data);
                    }
                }
            }
        }
        //echo 'fin de suma turno por clave';
        return 'sm_tc';
    }

    //operacion suma turno partida
    public function sm_tp($val, $dep, $fechas, $usuario){
        //se consultan los turnos que existe menos el turno vacio
        $turnos = turnos::where('departamento_id', '=', $dep)
        ->with([
            'equipos'
        ])
        ->where('nomtur', '!=', 'Vacío')
        ->get();
        //Consulta de claves
        $partida = carga::where('departamento_id', '=', $dep)
        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
        ->distinct()
        ->get(['partida','norma','clave_id']);
        //recorrdio de turno
        foreach ($turnos as $tur) {
            //recorrido de partida
            foreach ($partida as $pr) {
                //si la partida existe
                if ($pr['partida'] != 'N/A') {
                    $fs = 0;
                    $fc = 0;
                    foreach ($val->formulas as $value){
                        $proce_id = $value->proceso_id;
                        $maq_id = $value->maq_pros_id;

                        //suma
                        $suma = carga::where('departamento_id', '=', $dep)
                            ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                            ->where('partida', '=', $pr->partida)
                            ->where('clave_id', '=', $pr->clave_id)
                            ->where('turno_id', '=', $tur->id)
                            -> where('maq_pro_id', '=', $maq_id)
                            ->sum('valor');

                        //catidad
                        $cuenta = carga::where('departamento_id', '=', $dep)
                            ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                            ->where('partida', '=', $pr->partida)
                            ->where('clave_id', '=', $pr->clave_id)
                            ->where('turno_id', '=', $tur->id)
                            -> where('maq_pro_id', '=', $maq_id)
                            ->count('valor');
                        //resultado
                        $fs += $suma;
                        $fc += $cuenta;
                    }
                    $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => $tur->equipos[0]->id, 'turno_id' => $tur->id, 'cantidad' => $fc, 'partida' => $pr->partida, 'norma' => $pr->norma, 'clave_id' => $pr->clave_id, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id, 'partida_id' => null];
                    if ($fc != 0) {
                        //print_r($proce_id.' -/ '.$fc.' \- '.$pr->partida.' || ');
                        $this->gua_act($fechas, $data);
                    }
                }
            }
        }
    }

    //operacion suma semanal
    public function sem_sm($val, $dep, $fechas, $usuario){
        $semana = date("Y", strtotime($fechas['fecha'])).'-W'.date("W", strtotime($fechas['fecha']));
        $fs = 0;
        $fc = 0;
        //recorrido de formulas
        foreach ($val->formulas as $value) {
            $proce_id = $value->proceso_id;
            //Consulta para la suma
            $suma = carga::where('departamento_id', '=', $dep)
                ->where('semana', '=', $semana)
                ->where('maq_pro_id', '=', $value->maq_pros_id)
                ->sum('valor');

            //Consulta de paquetes contados
            $cuenta = carga::where('departamento_id', '=', $dep)
                ->where('semana', '=', $semana)
                -> where('maq_pro_id', '=', $value->maq_pros_id)
                ->count('valor');

            //variablesde operaciones
            $fs += $suma;
            $fc += $cuenta;
        }
        $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => null, 'turno_id' => null, 'cantidad' => $fc, 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep];
        if ($fc != 0) {
            $this->gua_act_sem($fechas, $data);
        }
        //print($fs.' | '.$fc.' Fin de suma semana / ');
        return 'sem_sm';
    }

    //operacion mes suma
    public function mes_sm($val, $dep, $fechas, $usuario){
        $mes = date("Y-m", strtotime($fechas['fecha']));
        $fs = 0;
        $fc = 0;
        foreach ($val->formulas as $value){
            $proce_id = $value->proceso_id;
            //Consulta para la suma
            $suma = carga::where('departamento_id', '=', $dep)
                ->where('fecha', 'like', '%'.$mes.'%')
                ->where('maq_pro_id', '=', $value->maq_pros_id)
                ->sum('valor');

            //Consulta de paquetes contados
            $cuenta = carga::where('departamento_id', '=', $dep)
                ->where('fecha', 'like', '%'.$mes.'%')
                -> where('maq_pro_id', '=', $value->maq_pros_id)
                ->count('valor');

            //variablesde operaciones
            $fs += $suma;
            $fc += $cuenta;
        }
        $data = ['proceso_id' => $proce_id, 'suma' => $fs, 'equipo_id' => null, 'turno_id' => null, 'cantidad' => $fc, 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep];
        if ($fc != 0) {
            $this->gua_act_mes($fechas, $data);
        }
        //print($fs.' | '.$fc.' Fin de suma mes / ');
        return 'mes_sm';
    }

    //operacion eficiencia dia
    public function efi_dia($val, $dep, $fechas, $usuario){
        //Contador y suma final
        $fs = 0;
        //Contador y suma de produccion
        $fsP = 0;
        //Contador y suma de objetivos
        $fsO = 0;
        //Segundo recorrido para procesos
        foreach ($val->formulas as $formu) {
            //si su tipo es de produccion realiza la suma
            if ($formu->proc_relas->tipo == 1) {
                $proce_id = $formu->proceso_id;
                $maq_id = $formu->maq_pros_id;

                //suma
                $suma = carga::where('departamento_id', '=', $dep)
                    ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    -> where('maq_pro_id', '=', $formu->maq_pros_id)
                    ->sum('valor');

                //resultado
                $fsP += $suma;
            }else{
                //suma
                $suma = carga::where('departamento_id', '=', $dep)
                    ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                    -> where('maq_pro_id', '=', $formu->maq_pros_id)
                    ->sum('valor');

                //resultado
                $fsO += $suma;
            }
        }

        if ($fsP != 0 & $fsO != 0) {
            $fs = ($fsP*100)/$fsO;
            $data = ['proceso_id' => $proce_id, 'suma' => round($fs, '2'), 'equipo_id' => null, 'turno_id' => null, 'cantidad' => '% ', 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id, 'partida_id' => null];
            $this->gua_act($fechas, $data);
        }
        print ' fin eficiencia clave dia //////// ';
    }

    //operacion eficiencia turno
    public function efi_cla($val, $dep, $fechas, $usuario){
        //se consultan los turnos que existe menos el turno vacio
        $turnos = turnos::where('departamento_id', '=', $dep)
        ->with([
            'equipos'
        ])
        ->where('nomtur', '!=', 'Vacío')
        ->get();
        //Consulta de claves
        $claves = carga::where('departamento_id', '=', $dep)
        ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
        ->distinct()
        ->get(['norma','clave_id']);
        //recorrido de los turnos
        foreach ($turnos as $tur) {
            //recorrrido de las claves
            foreach ($claves as $cla) {

                //Contador y suma final
                $fs = 0;
                //Contador y suma de produccion
                $fsP = 0;
                //Contador y suma de objetivos
                $fsO = 0;
                $clave = $cla->clave_id;
                $norma = $cla->norma;
                //recorrdio de los procesos
                foreach ($val->formulas as $formu) {
                    //La clave tiene que ser difeente de nulo
                    if (!empty($cla->clave_id)) {
                        //si su tipo es de produccion realiza la suma
                        if ($formu->proc_relas->tipo == 1) {
                            $proce_id = $formu->proceso_id;
                            $maq_id = $formu->maq_pros_id;

                            //suma
                            $suma = carga::where('departamento_id', '=', $dep)
                                ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                                ->where('clave_id', '=', $cla->clave_id)
                                ->where('turno_id', '=', $tur->id)
                                -> where('maq_pro_id', '=', $formu->maq_pros_id)
                                ->sum('valor');

                            //resultado
                            $fsP += $suma;
                        }else{
                            //suma
                            $suma = carga::where('departamento_id', '=', $dep)
                                ->whereBetween('fecha', [$fechas['hoy'], $fechas['mañana']])
                                ->where('clave_id', '=', $cla->clave_id)
                                ->where('turno_id', '=', $tur->id)
                                -> where('maq_pro_id', '=', $formu->maq_pros_id)
                                ->sum('valor');

                            //resultado
                            $fsO += $suma;
                        }
                    }
                }
                if ($fsP != 0 & $fsO != 0) {
                    $fs = ($fsP*100)/$fsO;
                    $data = ['proceso_id' => $proce_id, 'suma' => round($fs, '2'), 'equipo_id' => $tur->equipos[0]->id, 'turno_id' => $tur->id, 'cantidad' => '%', 'partida' => 'N/A', 'norma' => $norma, 'clave_id' => $clave, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id, 'partida_id' => null];
                    //print($val->nompro.' | '.$cla->clave->CVE_ART.' | '.$fsP.' - '.' | '.$fsO.' - '.' | '.round($fs, '2').' // ');
                    $this->gua_act($fechas, $data);
                }
            }
        }

        print ' fin eficiencia clave turno //////// ';
    }

    //Operacion eficiencia semana
    public function efi_sem($val, $dep, $fechas, $usuario){
        $semana = date("Y", strtotime($fechas['fecha'])).'-W'.date("W", strtotime($fechas['fecha']));
        ////Contador y suma final
        $fs = 0;
        //Contador y suma de produccion
        $fsP = 0;
        //Contador y suma de objetivos
        $fsO = 0;
        foreach ($val->formulas as $formu) {
            # code...
            if ($formu->proc_relas->tipo == 1) {
                $proce_id = $formu->proceso_id;
                $maq_id = $formu->maq_pros_id;

                //suma
                $suma = carga::where('departamento_id', '=', $dep)
                    ->where('semana', '=', $semana)
                    -> where('maq_pro_id', '=', $formu->maq_pros_id)
                    ->sum('valor');

                //resultado
                $fsP += $suma;
            }else{
                //suma
                $suma = carga::where('departamento_id', '=', $dep)
                    ->where('semana', '=', $semana)
                    -> where('maq_pro_id', '=', $formu->maq_pros_id)
                    ->sum('valor');
                //resultado
                $fsO += $suma;
            }
        }
        if ($fsP != 0 & $fsO != 0) {
            //print $fsO.' '.$fsP.' /';
            $fs = ($fsP*100)/$fsO;
            $data = ['proceso_id' => $proce_id, 'suma' => round($fs, '2'), 'equipo_id' => null, 'turno_id' => null, 'cantidad' => '% ', 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id];
            print_r($data);
            //$this->gua_act($fechas, $data);
            $this->gua_act_sem($fechas, $data);
        }
        //return $data;
    }

    /************************** Operaciones Horario punta ****************************************/

    //suma diaria horario punta
    public function sm_pun_d(){}

    //suma semanal horario punta
    public function sem_pun_sm(){}

    //suma mensual horario punta
    public function mes_pun_sm(){}

    //operacion eficiencia puta diario
    public function efi_pun_dia($val, $dep, $fechas, $usuario){
        //Contador y suma final
        $fs = 0;
        //Contador y suma de produccion
        $fsP = 0;
        //nuevos arreglos
        $obje = [];

        $nfec = $fechas['fecha']." 07:00:00";
        $onfec = date("Y-m-d H:i:s", strtotime($nfec."+ 1 days" ));

        //Segundo recorrido para procesos
        foreach ($val->formulas as $formu) {
            //si su tipo es de produccion realiza la suma
            if ($formu->proc_relas->tipo == 1) {
                $proce_id = $formu->proceso_id;
                $maq_id = $formu->maq_pros_id;

                //suma
                $suma = carga::where('departamento_id', '=', $dep)
                    ->whereBetween('fecha', [$nfec, $onfec])
                    -> where('maq_pro_id', '=', $formu->maq_pros_id)
                    ->sum('valor');

                //resultado
                $fsP += $suma;
            }else{
                array_push($obje, $formu->maq_pros_id);
            }
        }

        $nusumO = carga::join('objetivo_puntas', 'objetivo_puntas.carga_id', '=', 'cargas.id')
            ->where('cargas.departamento_id', '=', $dep)
            ->whereBetween('cargas.fecha', [$nfec, $onfec])
            ->whereIn('maq_pro_id', $obje)
            ->selectRaw('SUM(objetivo_puntas.valorPu) AS valor')
            ->first();


        if ($fs != 0) {
            $fs = ($fsP*100)/$nusumO->valor;
            $data = ['proceso_id' => $proce_id, 'suma' => round($fs, '2'), 'equipo_id' => null, 'turno_id' => null, 'cantidad' => '% ', 'partida' => 'N/A', 'norma' => null, 'clave_id' => null, 'per_carga' => $usuario->id, 'departamento_id' => $dep,'maq_pro_id' => $maq_id];
            $this->gua_act($fechas, $data);
        }
        //print ' fin eficiencia clave dia //////// ';
    }

    //Operacion eficiencia semanal
    public function efi_pun_sem($val, $dep, $fechas, $usuario){
        //
        $semana = date("Y", strtotime($fechas['fecha'])).'-W'.date("W", strtotime($fechas['fecha']));
        $proce = [];
        $obje = [];

        foreach ($val->formulas as $formu) {
            //si su tipo es de produccion realiza la suma
            if ($formu->proc_relas->tipo == 1) {
                array_push($proce, $formu->maq_pros_id);
            }
            else{
                array_push($obje, $formu->maq_pros_id);
            }
        }
        $suma = carga::where('departamento_id', '=', $dep)
        ->where('semana', '=', $semana)
        ->whereIn('maq_pro_id', $proce)
        ->selectRaw('SUM(valor) AS valor')
        ->first();

        $sumaO = carga::join('objetivo_puntas', 'objetivo_puntas.carga_id', '=', 'cargas.id')
        ->where('cargas.departamento_id', '=', $dep)
        ->where('semana', '=', $semana)
        ->whereIn('maq_pro_id', $obje)
        ->selectRaw('SUM(objetivo_puntas.valorPu) AS valor')
        ->first();
        print($sumaO);
    }

    //Operacion eficiencia mensual
    public function efi_pun_mes($val, $dep, $fechas, $usuario){
        //
    }
}
