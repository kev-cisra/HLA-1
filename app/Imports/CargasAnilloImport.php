<?php

namespace App\Imports;

use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\carga;
use App\Models\Produccion\carOpe;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\turnos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToModel;

class CargasAnilloImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dp = carOpe::where('id', '=', $row['paquete_operador'])
        ->withTrashed()
        ->with([
            'dep_per' => function($dp) {
                $dp -> select('id', 'perfiles_usuarios_id', 'equipo_id');
            }
        ])
        ->first(['id', 'proceso_id', 'dep_perf_id', 'maq_pro_id', 'departamento_id']);

        $tur = turnos::where('nomtur', 'like', '%'.$row['turno'].'%')->where('departamento_id', '=', $dp->departamento_id)->first(['id']);

        $par = admi_abas::where('partida', '=', $row['partida'])->where("departamento_id", '=', 8)->first();

        $cla = claves::where('CVE_ART', '=', $row['clave'])->first();

        $per = PerfilesUsuarios::where('user_id', '=', Auth::id())->first();

        $nc = dep_per::join('perfiles_usuarios', 'perfiles_usuarios.id', '=', 'dep_pers.perfiles_usuarios_id')
        ->where('dep_pers.departamento_id', '=', $par->departamento_id)
        ->where('perfiles_usuarios.IdEmp', '=', $row['no_control'])
        ->selectRaw('dep_pers.id')
        ->first();

        return new carga([
            'fecha' => $this->transformDateTime($row['fecha']),
            'semana' => date("Y", strtotime($this->transformDateTime($row['fecha']))).'-W'.date("W", strtotime($this->transformDateTime($row['fecha']))),
            'valor' => $row['peso'],
            'partida' => $row['partida'].'.'.$row['com_part'],
            'partida_id' => $par->id,
            'equipo_id' => $dp->dep_per->equipo_id,
            'dep_perf_id' => $nc->id,
            'norma' => $cla->dep_mat_id,
            'proceso_id' => $dp->proceso_id,
            'maq_pro_id' => $dp->maq_pro_id,
            'clave_id' => $cla->id,
            'turno_id' => $tur->id,
            'departamento_id' => $par->departamento_id,
            'per_carga' => $per->id,
            'VerInv' => 1,
        ]);
    }

    private function transformDateTime(string $value, string $format = 'Y-m-d H:i')
    {
        try {
            return Carbon::instance(Date::excelToDateTimeObject($value))->format($format);
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }
}
