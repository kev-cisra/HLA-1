<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\procesos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class parosCarga extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos inversa
    public function paros(){
        return $this->belongsTo(paros::class, 'paro_id');
    }

    //Relaciones recursivas
    public function paros_sub() {
        return $this->hasMany(parosCarga::class, 'paros_carga_id');
    }

    public function sub_paro() {
        return $this->hasMany(parosCarga::class, 'paros_carga_id')->with('paros_sub');
    }

    public function perfil_ini(){
        return $this->belongsTo(PerfilesUsuarios::class, 'perfil_ini_id');
    }

    public function perfil_fin(){
        return $this->belongsTo(PerfilesUsuarios::class, 'perfil_fin_id');
    }

    public function maq_pro(){
        return $this->belongsTo(maq_pro::class, 'maq_pro_id');
    }

    public function proceso(){
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function departamento(){
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }
}
