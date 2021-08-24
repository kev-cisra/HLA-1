<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class turnos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function equipos() {
        return $this->hasMany(equipos::class, 'turno_id');
    }

    //relacion uno a muchos inversa
    public function departamento(){
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }
}
