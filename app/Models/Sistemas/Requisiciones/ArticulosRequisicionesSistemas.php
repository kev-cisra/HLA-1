<?php

namespace App\Models\Sistemas\Requisiciones;

use App\Models\Sistemas\Hardware\HardwareSistemas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class ArticulosRequisicionesSistemas extends Model{

    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion muchos a uno
    public function ArticulosRequisicion() {
        return $this->belongsTo(RequisicionesSistemas::class, 'requisicion_sistemas_id');
    }

    //relacion uno a uno con Modelo HardwareSistemas
    public function Hardware() {
        return $this->belongsTo(HardwareSistemas::class, 'Hardware_id');
    }
}
