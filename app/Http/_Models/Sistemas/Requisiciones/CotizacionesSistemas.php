<?php

namespace App\Models\Sistemas\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class CotizacionesSistemas extends Model{

    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos con PreciosCotizaciones
    public function Precios() {
        return $this->hasMany(PreciosCotizacionesSistemas::class, 'cotizacion_sistemas_id');
    }

    //relacion uno a uno con Modelo HardwareSistemas
    public function Requisicion() {
        return $this->belongsTo(RequisicionesSistemas::class, 'id');
    }

    //relacion uno a uno con Proveedores Sistemas
    public function Proveedor() {
        return $this->belongsTo(ProveedoresSistemas::class, 'Proveedor_Sistemas_id');
    }
}
