<?php

namespace App\Models\Sistemas\Mantenimientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class CalendarioMantenimientos extends Model{

    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a uno con Modelo Perfiles
    public function Perfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'Perfil_id');
    }

    //relacion uno a uno con Modelo HardwareSistemas
    public function Hardware() {
        return $this->belongsTo(HardwareSistemas::class, 'Hardware_id');
    }
}
