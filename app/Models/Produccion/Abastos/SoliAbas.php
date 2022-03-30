<?php

namespace App\Models\Produccion\Abastos;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoliAbas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];
    protected $softCascade = ['alma_abas']; //eliminar en cascada

    //relacion uno a muchos
    public function alma_abas(){
        return $this->hasMany(AlmaAbas::class, 'soli_aba_id');
    }

    //relacion uno a uno
    public function aba_entrega(){
        return $this->hasOne(AbaEntregas::class, 'soli_aba_id');
    }

    //relacion uno a muchos inversa
    public function admin_aba(){
        return $this->belongsTo(admi_abas::class, 'admi_abas_id');
    }

    public function depa_solici(){
        return $this->belongsTo(Departamentos::class, 'depa_solicita');
    }

    public function depa_entrega(){
        return $this->belongsTo(Departamentos::class, 'depa_entregar');
    }
}
