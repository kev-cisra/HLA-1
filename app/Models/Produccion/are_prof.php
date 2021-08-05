<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Areas;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class are_prof extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function areperf_cargas() {
        return $this->hasMany(carga_produccion::class);
    }

    //relacion uno a muchos inversa
    public function areperf_perfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'perfiles_usuarios_id');
    }

    public function areperf_area() {
        return $this->belongsTo(Areas::class, 'area_id');
    }
}
