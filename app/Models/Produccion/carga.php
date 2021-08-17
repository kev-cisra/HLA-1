<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\catalogos\procesos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class carga extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //Relacion 1 a muchos inversa
    public function dep_perf(){
        return $this->belongsTo(dep_perf::class, 'dep_perf_id');
    }

    public function proceso(){
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function maq_pro() {
        return $this->belongsTo(maq_pro::class, 'maq_pro_id');
    }

    public function clave() {
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function turno() {
        return $this->belongsTo(turnos::class, 'turno_id');
    }
}
