<?php

namespace App\Models\Sistemas\Requisiciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class RequisicionesSistemas extends Model{

    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //Relacion de Requisicion a Precios
    public function Perfil() {
        return $this->hasOne(PerfilesUsuarios::class, 'id', 'Perfil_id');
    }
}
