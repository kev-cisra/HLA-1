<?php

namespace App\Models\Produccion;

use App\Models\Catalogos\Maquinas;
use App\Models\obje_cordi;
use App\Models\Produccion\catalogos\procesos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use PhpParser\Builder\Function_;

class maq_pro extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    use SoftCascadeTrait;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];
    protected $softCascade = ['formulas']; //eliminar en cascada

    //relacion 1 a muchos
    public function cargas() {
        return $this->hasMany(carga::class);
    }

    public function formulas() {
        return $this->hasMany(formulas::class, 'maq_pros_id');
    }

    public function parocargas(){
        return $this->hasMany(parosCarga::class, 'maq_pro_id');
    }

    public function carOpes(){
        return $this->hasMany(carOpe::class, 'maq_pro_id');
    }

    public function obje_cordi(){
        return $this->hasMany(obje_cordi::class, 'maq_pro_id');
    }

    //relacion 1 a muchos inversas
    public function procesos() {
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function maquinas() {
        return $this->belongsTo(Maquinas::class, 'maquina_id');
    }


}
