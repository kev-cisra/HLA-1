<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Areas;
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
    public function turno_cargas(){
        return $this->hasMany(carga_produccion::class);
    }

    //relacion uno a muchos inversa
    public function turnos_area(){
        return $this->belongsTo(Areas::class, 'area_id');
    }
}
