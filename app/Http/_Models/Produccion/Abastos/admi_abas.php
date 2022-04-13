<?php

namespace App\Models\Produccion\Abastos;

use App\Models\Calidad\ProceCalidad;
use App\Models\Produccion\carga;
use App\Models\Produccion\carNorm;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class admi_abas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];
    protected $softCascade = ['soli_abas', 'aba_entregas', 'proc_final_aba']; //eliminar en cascada

    //relacion uno a muchos
    public function soli_abas(){
        return $this->hasMany(SoliAbas::class, 'admi_abas_id');
    }

    public function aba_entregas(){
        return $this->hasMany(AbaEntregas::class, 'admi_abas_id');
    }

    public function proc_final_aba(){
        return $this->hasMany(ProcFinAbas::class, 'admi_abas_id');
    }

    public function car_norms(){
        return $this->hasMany(carNorm::class, 'partida_id');
    }

    public function cargas(){
        return $this->hasMany(carga::class, 'partida_id');
    }

    public function proceCalidad(){
        return $this->hasMany(ProceCalidad::class, 'partida_id');
    }

    //relacion uno a muchos inversa
    public function departamento(){
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    public function perfile(){
        return $this->belongsTo(PerfilesUsuarios::class, 'perfil_id');
    }
}
