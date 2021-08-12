<?php

namespace App\Models\Produccion\catalogos;

use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class procesos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    const Encargado = 1;
    const Coordinador = 2;
    const Formulas = 3;

    //Relaciones 1 a muchos
    public function maq_pros(){
        return $this->hasMany(maq_pro::class, 'proceso_id');
    }


    //Relaciones 1 a muchos inversas
    public function departamentos() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }
}
