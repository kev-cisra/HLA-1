<?php

namespace App\Imports;

use App\Models\Produccion\carga;
use App\Models\Produccion\carNorm;
use App\Models\Produccion\carOpe;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\turnos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class CargasImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dp = carOpe::where('id', '=', $row['paquete_operador'])
        ->with([
            'dep_per' => function($dp) {
                $dp -> select('id', 'perfiles_usuarios_id', 'equipo_id');
            }
        ])
        ->first(['id', 'proceso_id', 'dep_perf_id', 'maq_pro_id', 'departamento_id']);

        $pn = carNorm::where('id', '=', $row['paquete_norma'])->first(['id', 'partida', 'norma', 'clave_id', 'departamento_id']);

        //consulta para mostrar el equipo y el turno
        $tur = turnos::where('nomtur', 'like', '%'.$row['turno'].'%')->where('departamento_id', '=', $dp->departamento_id)->first(['id']);

        return new carga([
            'fecha' => $this->transformDateTime($row['fecha']),
            'semana' => date("Y", strtotime($this->transformDateTime($row['fecha']))).'-W'.date("W", strtotime($this->transformDateTime($row['fecha']))),
            'valor' => $row['peso'],
            'partida' => $pn->partida,
            'equipo_id' => $dp->dep_per->equipo_id,
            'dep_perf_id' => $dp->dep_perf_id,
            'norma' => $pn->norma,
            'proceso_id' => $dp->proceso_id,
            'maq_pro_id' => $dp->maq_pro_id,
            'clave_id' => $pn->clave_id,
            'turno_id' => $tur->id,
            'departamento_id' => $dp->departamento_id,
            'per_carga' => Auth::id(),
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
