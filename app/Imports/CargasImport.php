<?php

namespace App\Imports;

use App\Models\Produccion\carga;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\equipos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class CargasImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $fecha =strtotime($row['fecha']);
        //consulta para mostrar el dep_perf
        $dp = dep_per::join('perfiles_usuarios', 'perfiles_usuarios.id', 'dep_pers.perfiles_usuarios_id')->where('perfiles_usuarios.IdEmp', '=', $row['operador'])->first(['dep_pers.id AS id', 'dep_pers.departamento_id AS iddepa']);
        //Consultas para mostrar la clave y la norma
        $cla = claves::join('dep_mats', 'dep_mats.id', '=', 'claves.dep_mat_id')->join('materiales', 'materiales.id', '=', 'dep_mats.material_id')->where('dep_mats.departamento_id', '=', $dp->iddepa)->where('CVE_ART', '=', $row['clave'])->first(['claves.id AS idcl', 'dep_mats.id AS iddm']);
        //consulta para mostrar el equipo y el turno
        $equi = equipos::where('nombre', 'like', '%'.$row['equipo'].'%')->where('departamento_id', '=', $dp->iddepa)->first(['id', 'turno_id']);

        return new carga([
            'fecha' => date('Y-m-d h:i:s', $fecha),
            'semana' => date("Y", strtotime($row['fecha'])).'-W'.date("W", strtotime($row['fecha'])),
            'valor' => $row['peso'],
            'partida' => $row['partida'],
            'equipo_id' => $equi->id,
            'dep_perf_id' => $dp->id,
            'norma' => $cla->iddm,
            'proceso_id' => $row['proceso'],
            'maq_pro_id' => $row['maquina'],
            'clave_id' => $cla->idcl,
            'turno_id' => $equi->turno_id,
            'departamento_id' => $dp->iddepa,
            'per_carga' => Auth::id(),
            'VerInv' => 1,
        ]);
    }


}
