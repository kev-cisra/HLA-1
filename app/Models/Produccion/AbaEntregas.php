<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
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
    public function norma(){
        return $this->belongsTo(dep_mat::class, 'norma_id');
    }

    public function clave(){
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function depa_entregas(){
        return $this->belongsTo(Departamentos::class, 'depa_entrega');
    }

    public function depa_recibe(){
        return $this->belongsTo(Departamentos::class, 'depa_recibe');
    }
}
