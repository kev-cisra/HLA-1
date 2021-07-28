<?php

namespace App\Models\Produccion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class per_procs extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function perproc_cargas() {
        return $this->hasMany('App\Models\Produccion\carga_produccion');
    }

    //relacion uno a muchos inversa
    public function perprocs_proceso() {
        return $this->belongsTo('App\Models\Produccion\procesos', 'proceso_id');
    }

    public function perprocs_perfil() {
        return $this->belongsTo('App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios', 'perfil_id');
    }
}
