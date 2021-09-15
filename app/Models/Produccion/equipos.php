<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class equipos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function dep_pers(){
        return $this->hasMany(dep_per::class, 'equipo_id');
    }

    public function departamento() {
        return $this->hasMany(Departamentos::class);
    }

    public function cargas() {
        return $this->hasMany(carga::class, 'equipo_id');
    }

    //relacion uno a muchos inversa
    public function turnos() {
        return $this->belongsTo(turnos::class, 'turno_id');
    }
}
