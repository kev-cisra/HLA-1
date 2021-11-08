<?php

namespace App\Models\Compras\Requisiciones;

use App\Models\Catalogos\Maquinas;
use App\Models\Catalogos\MarcasMaquinas;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
class Requisiciones extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    //relacion uno a muchos
    public function RequisicionesPerfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'Perfil_id');
    }

    //relacion uno a muchos
    public function RequisicionArticulos() {
        return $this->hasMany(ArticulosRequisiciones::class, 'requisicion_id');
    }

    // Relacion 1 a 1 con Departamento
    public function RequisicionDepartamento() {
        return $this->hasOne(Departamentos::class, 'id', 'Departamento_id');
    }

    public function RequisicionJefe() {
        return $this->hasOne(JefesArea::class, 'id', 'jefes_areas_id');
    }

    public function RequisicionMaquina() {
        return $this->hasOne(Maquinas::class, 'id', 'Maquina_id');
    }

    public function RequisicionMarca() {
        return $this->hasOne(MarcasMaquinas::class, 'id', 'Marca_id');
    }

    //relacion muchos a uno
    public function ArticuloPrecios() {
        return $this->hasMany(PreciosCotizaciones::class, 'articulos_requisiciones_id');
    }

}
