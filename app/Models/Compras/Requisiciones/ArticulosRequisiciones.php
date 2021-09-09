<?php

namespace App\Models\Compras\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
class ArticulosRequisiciones extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion muchos a uno
    public function ArticulosRequisicion() {
        return $this->belongsTo(Requisiciones::class, 'requisicion_id');
    }

    //relacion muchos a uno
    public function ArticuloPrecios() {
        return $this->hasMany(PreciosCotizaciones::class, 'articulos_requisiciones_id');
    }
}
