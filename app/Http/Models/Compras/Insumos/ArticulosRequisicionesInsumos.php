<?php

namespace App\Models\Compras\Insumos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class ArticulosRequisicionesInsumos extends Model{

    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    // Relacion 1 a 1 con Departamento
    public function Insumo() {
        return $this->hasOne(Insumos::class, 'id', 'insumo_id');
    }
}
