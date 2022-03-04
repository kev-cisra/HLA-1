<?php

namespace App\Imports;

use App\Models\obje_cordi;
use App\Models\Produccion\dep_mat;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MatrizObjeImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cal = dep_mat::where('departamento_id', '=', $row['departamento_id'])
        ->join('claves', 'dep_mats.id', '=', 'claves.dep_mat_id')
        ->where('claves.CVE_ART', '=', $row['clave_id'])
        ->selectRaw('claves.id AS clave_id, dep_mats.id AS dep_mat_id, claves.torsion, dep_mats.material_id ')
        ->first();

        return new obje_cordi([
            'estatus' => 1,
            'tipo_maqui' => $row['tipo_maqui'],
            'pro_hora' => $row['pro_hora'],
            'tiempo' => $row['tiempo'],
            'eficiencia' => $row['eficiencia'],
            'velocidad' => $row['velocidad'],
            'constante' => $row['constante'],
            'cabos' => $row['cabos'],
            'husos' => $row['husos'],
            'titulo' => $row['titulo'],
            'formula' => $row['formula'],
            'proceso_id' => $row['proceso_id'],
            'maq_pro_id' => $row['maq_pro_id'],
            'norma' => $cal->dep_mat_id,
            'clave_id' => $cal->clave_id,
            'departamento_id' => $row['departamento_id']
        ]);
    }
}
