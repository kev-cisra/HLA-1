<?php

namespace App\Models\RecursosHumanos\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class Areas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function area_procesos(){
        return $this->hasMany('App\Models\Produccion\procesos');
    }

    public function area_turnos(){
        return $this->hasMany('App\Models\Produccion\tuenos');
    }
}
