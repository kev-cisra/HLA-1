<?php

namespace App\Models\RecursosHumanos\Catalogos;

use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\are_prof;
use App\Models\Produccion\procesos;
use App\Models\Produccion\turnos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class Areas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    const P = 1;
    const PH = 2;
    const H = 3;
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function area_procesos(){
        return $this->hasMany(procesos::class);
    }

    public function area_turnos(){
        return $this->hasMany(turnos::class);
    }

    public function area_areperfs() {
        return $this->hasMany(are_prof::class);
    }

    public function area_maquinas() {
        return $this->hasMany(Maquinas::class);
    }

    //relaciones recursiva
    public function areas_sub() {
        return $this->hasMany(Areas::class);
    }

    public function sub_areas() {
        return $this->hasMany(Areas::class, 'areas_id')->with('areas_sub');
    }
}
