<?php

namespace App\Models\Produccion\catalogos;

use App\Models\obje_cordi;
use App\Models\Produccion\carga;
use App\Models\Produccion\carOpe;
use App\Models\Produccion\formulas;
use App\Models\Produccion\maq_pro;
use App\Models\Produccion\parosCarga;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class procesos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    use SoftCascadeTrait;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];
    protected $softCascade = ['maq_pros', 'formulas', 'formu_proc', 'carOpes', 'proceso_sub']; //eliminar en cascada

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

    public function formu_proc(){
        return $this->hasMany(formulas::class, 'proc_rela');
    }

    public function paroscargas(){
        return $this->hasMany(parosCarga::class, 'proceso_id');
    }

    public function carOpes(){
        return $this->hasMany(carOpe::class, 'proceso_id');
    }

    public function obje_cordi() {
        return $this->hasMany(obje_cordi::class, 'proceso_id');
    }

    public function grafi_arrs(){
        return $this->hasMany(grafi_arr::class, 'proceso_id');
    }

    public function grafi_arrs_linea(){
        return $this->hasMany(grafi_arr::class, 'proceso_linea_id');
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
