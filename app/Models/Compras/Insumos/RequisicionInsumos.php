<?php

namespace App\Models\Compras\Insumos;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
class RequisicionInsumos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];
    use HasFactory;

    public function RequisicionesInsumosMaterial() {
        return $this->belongsTo(Insumos::class, 'Insumo_id');
    }

    public function RequisicionesInsumosPerfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'IdUser');
    }

    // Relacion 1 a 1 con Departamento
    public function RequisicionInsumosDepartamento() {
        return $this->hasOne(Departamentos::class, 'id', 'Departamento_id');
    }
}
