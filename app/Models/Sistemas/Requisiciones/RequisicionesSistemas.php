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

    //relacion uno a muchos con CotizacionesSistemas
    public function Cotizacion() {
        return $this->hasMany(CotizacionesSistemas::class, 'requisicion_sistemas_id');
    }

    //Scope con consulta base para requisiciones Sistemas
    public function scopeReqSistemas($query){
        return $query->with([
            'Perfil' => function($Perfil) { //Relacion 1 a 1 De puestos
                $Perfil->select('id', 'Nombre', 'ApPat', 'ApMat');
            },
            'Departamento' => function($Departamento) { //Relacion 1 a 1 De puestos
                $Departamento->select('id', 'Nombre');
            },
            'Articulos' => function($Articulos) { //Relacion 1 a 1 De puestos
                $Articulos->select('id', 'IdUser', 'Cantidad', 'Unidad', 'Dispositivo', 'requisicion_sistemas_id');
            }
        ]);
    }

    //Scope local en Supply para mostrar solo los estatus 0->Rechazado y los estatus mayores a 4->Autorizar
    public function scopeEstatus($query){
        return $query->where('Estatus', '!=', 1)->where('Estatus', '!=', 2)->where('Estatus', '!=', 3);
    }
}
