<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave


class dep_per extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    // Relaciones 1 a muchos
    public function cargas() {
        return $this->hasMany(carga::class, 'dep_perf_id');
    }

    // Relaciones inversas 1 a muchos
    public function departamentos() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    public function perfiles() {
        return $this->belongsTo(PerfilesUsuarios::class, 'perfiles_usuarios_id');
    }

    public function equipo() {
        return $this->belongsTo(equipos::class, 'equipo_id');
    }
}
