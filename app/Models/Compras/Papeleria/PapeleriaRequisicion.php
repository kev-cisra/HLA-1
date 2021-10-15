<?php

namespace App\Models\Compras\Papeleria;

use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class PapeleriaRequisicion extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];
    use HasFactory;

    // Relacion 1 a 1 con Departamento
    public function RequisicionDepartamento() {
        return $this->hasOne(Departamentos::class, 'id', 'Departamento_id');
    }

    public function RequisicionJefe() {
        return $this->hasOne(JefesArea::class, 'id', 'jefes_areas_id');
    }

    public function RequisicionPerfil() {
        return $this->hasOne(PerfilesUsuarios::class, 'id', 'Perfil_id');
    }
}
