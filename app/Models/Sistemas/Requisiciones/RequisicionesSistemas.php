<?php

namespace App\Models\Sistemas\Requisiciones;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use App\Models\Compras\Requisiciones\ArticulosRequisiciones;
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

    // Relacion 1 a 1 con Departamento
    public function Departamento() {
        return $this->hasOne(Departamentos::class, 'id', 'Departamento_id');
    }

    //relacion uno a muchos
    public function Articulos() {
        return $this->hasMany(ArticulosRequisicionesSistemas::class, 'requisicion_sistemas_id');
    }
}
