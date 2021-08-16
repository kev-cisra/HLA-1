<?php

namespace App\Models\Produccion;

use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\catalogos\procesos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class maq_pro extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion 1 a muchos
    public function cargas() {
        return $this->hasMany(carga::class);
    }

    public function formulas() {
        return $this->hasMany(formulas::class);
    }

    //relacion 1 a muchos inversas
    public function procesos() {
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function maquinas() {
        return $this->belongsTo(Maquinas::class, 'maquina_id');
    }
}
