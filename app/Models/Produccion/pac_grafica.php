<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\materiales;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pac_grafica extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    use SoftCascadeTrait;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];
    protected $softCascade = ['grafi_arrs']; //eliminar en cascada

    //relacion uno a muchos
    public function grafi_arrs(){
        return $this->hasMany(grafi_arr::class, 'pac_grafica_id');
    }

    //Relaciones 1 a muchos inversas
    public function departamentos() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }
}
