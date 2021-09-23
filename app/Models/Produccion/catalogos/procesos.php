<?php

namespace App\Models\Produccion\catalogos;

use App\Models\Produccion\carga;
use App\Models\Produccion\formulas;
use App\Models\Produccion\maq_pro;
use App\Models\Produccion\parosCarga;
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

    const Principal = 0;
    const Encargado = 1;
    const Coordinador = 2;
    const Formulas = 3;
    const Entregas = 4;
    const Mermas = 5;

    //Relaciones 1 a muchos
    public function maq_pros(){
        return $this->hasMany(maq_pro::class, 'proceso_id');
    }

    public function cargas(){
        return $this->hasMany(carga::class);
    }

    public function formulas(){
        return $this->hasMany(formulas::class, 'proceso_id');
    }

    public function paroscargas(){
        return $this->hasMany(parosCarga::class, 'proceso_id');
    }

    //Relaciones 1 a muchos inversas
    public function departamentos() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    //Relaciones recursivas
    public function proceso_sub(){
        return $this->hasMany(procesos::class, 'proceso_id');
    }

    public function sub_proceso() {
        return $this->hasMany(procesos::class, 'proceso_id')->with('proceso_sub');
    }
}
