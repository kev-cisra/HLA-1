<?php

namespace App\Models\Produccion\Abastos;

use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\dep_mat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcFinAbas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos inverso
    public function norma(){
        return $this->belongsTo(dep_mat::class, 'norma_id');
    }

    public function clave(){
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function admi_abi(){
        return $this->belongsTo(admi_abas::class, 'admi_abas_id');
    }
}
