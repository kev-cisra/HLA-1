<?php

namespace App\Models\Produccion\catalogos;

use App\Models\obje_cordi;
use App\Models\Produccion\Abastos\Alma_Abas;
use App\Models\Produccion\Abastos\AlmaAbas;
use App\Models\Produccion\Abastos\ProcFinAbas;
use App\Models\Produccion\carga;
use App\Models\Produccion\carNorm;
use App\Models\Produccion\dep_mat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class claves extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //Relaciones uno a muchos
    public function cargas(){
        return $this->hasMany(carga::class);
    }

    public function carNorms(){
        return $this->hasMany(carNorm::class, 'clave_id');
    }

    public function obje_cordi(){
        return $this->hasMany(obje_cordi::class, 'clave_id');
    }

    public function alma_abas(){
        return $this->hasMany(AlmaAbas::class, 'clave_id');
    }

    public function proc_fin_abas(){
        return $this->hasMany(ProcFinAbas::class, 'clave_id');
    }

    //relacion 1 a muchos inversa
    public function dep_mat(){
        return $this->belongsTo(dep_mat::class, 'dep_mat_id');
    }
}
