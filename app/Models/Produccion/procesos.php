<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Catalogos\Areas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class procesos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    const Encargado = 1;
    const Coordinador = 2;
    const Formulas = 3;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function proceso_perprocs() {
        return $this->hasMany(per_procs::class);
    }

    public function proceso_formulas() {
        return $this->hasMany(formulas::class);
    }

    //relacion uno a muchos inversa
    public function procesos_area() {
        return $this->belongsTo(Areas::class, 'areas_id');
    }
}
