<?php

namespace App\Imports;

use App\Models\Produccion\carga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
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

        return new carga([

            'fecha' => $row['fecha'],
            'semana' => date("Y", strtotime($row['fecha'])).'-W'.date("W", strtotime($row['fecha'])),
            'valor' => $row['peso'],
            'partida' => $row['partida'],
            'VerInv' => 1,
            'proceso_id' => 10,
            'departamento_id' => 4
        ]);
    }


}
