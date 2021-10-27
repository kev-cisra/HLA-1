<?php

namespace App\Imports;

use App\Models\Produccion\carga;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\equipos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class CargasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $fec = Carbon::now();
        $anio = $fec->format('Y');
        $equi = equipos::where('nombre', 'like', '%'.$row['equipo'].'%')->where('departamento_id', '=', 4)->first('id');
        $dp = dep_per::join('perfiles_usuarios', 'perfiles_usuarios.id', 'dep_pers.perfiles_usuarios_id')->where('perfiles_usuarios.IdEmp', '=', $row['operador'])->first('dep_pers.id', 'AS', 'id');
        return new carga([
            'fecha' => date("Y-m-d H:i:s", strtotime($row['fecha'])),
            'semana' => date("Y", strtotime($row['fecha'])).'-W'.date("W", strtotime($row['fecha'])),
            'valor' => $row['peso'],
            'partida' => $row['partida'],
            'equipo_id' => null,
            'dep_perf_id' => dep_per::join('perfiles_usuarios', 'perfiles_usuarios.id', 'dep_pers.perfiles_usuarios_id')->where('perfiles_usuarios.IdEmp', '=', $row['operador'])->first('dep_pers.id', 'AS', 'id')->id,
            'per_carga' => Auth::id(),
            'VerInv' => 1,
            'proceso_id' => 10,
            'departamento_id' => 4
        ]);
    }


}
