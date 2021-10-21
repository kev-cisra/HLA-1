<?php

namespace App\Imports;

use App\Models\Produccion\carga;
use Maatwebsite\Excel\Concerns\ToModel;

class CargasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        exit($row);
        return new carga([
            //
        ]);
    }
}
