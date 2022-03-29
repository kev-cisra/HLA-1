<?php

namespace App\Models\Compras\Insumos;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class Insumos extends Model{

    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    // Relacion 1 a 1 con Departamento
    public function Departamento() {
        return $this->hasOne(Departamentos::class, 'id', 'Departamento_id');
    }
}
