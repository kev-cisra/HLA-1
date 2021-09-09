<?php

namespace App\Models\Compras\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class PreciosCotizaciones extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion muchos a uno
    public function PreciosArticulo() {
        return $this->belongsTo(ArticulosRequisiciones::class, 'articulos_requisiciones_id');
    }
}
