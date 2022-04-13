<?php

namespace App\Models\Produccion\Abastos;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbaEntregas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function rela_aba_carga(){
        return $this->hasMany(rela_aba_carga::class, 'aba_entre_id');
    }

    //relacion uno a muchos inversa
    public function admin_abas(){
        return $this->belongsTo(admi_abas::class, 'admi_abas_id');
    }

    public function soli_aba(){
        return $this->belongsTo(SoliAbas::class, 'soli_aba_id');
    }

    public function perfi_aba(){
        return $this->belongsTo(PerfilesUsuarios::class, 'perfi_abas');
    }

    public function perfi_entrega(){
        return $this->belongsTo(PerfilesUsuarios::class, 'perfi_entrega');
    }
}
