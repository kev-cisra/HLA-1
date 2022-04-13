<?php

namespace App\Models\Sistemas\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class PreciosCotizacionesSistemas extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function Articulos() {
        return $this->hasOne(ArticulosRequisicionesSistemas::class, 'id');
    }

    //relacion uno a uno con Modelo HardwareSistemas
    public function Cotizacion() {
        return $this->belongsTo(CotizacionesSistemas::class, 'id');
    }
}
