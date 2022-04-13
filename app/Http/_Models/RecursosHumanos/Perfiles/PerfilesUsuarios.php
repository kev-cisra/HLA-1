<?php

namespace App\Models\RecursosHumanos\Perfiles;

use App\Models\Compras\Requisiciones\Requisiciones;
use App\Models\Produccion\Abastos\AbaEntregas;
use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\are_prof;
use App\Models\Produccion\carga;
use App\Models\Produccion\dep_per;
use App\Models\Produccion\notasCarga;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Catalogos\JefesArea;
use App\Models\RecursosHumanos\Catalogos\Puestos;
use App\Models\RecursosHumanos\Incidencias\Incidencias;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class PerfilesUsuarios extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    use SoftCascadeTrait;

    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['created_at','updated_at'];
    protected $softCascade = ['dep_pers']; //eliminar en cascada

    //relacion uno a uno inversa
    public function perfil_user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    //relacion uno a muchos
    public function dep_pers() {
        return $this->hasMany(dep_per::class);
    }

    public function cargas() {
        return $this->hasMany(carga::class, 'per_carga');
    }

    public function admin_abas() {
        return $this->hasMany(admi_abas::class, 'perfil_id');
    }

    public function abaEntre_aba(){
        return $this->hasMany(AbaEntregas::class, 'perfi_abas');
    }

    public function abaEntre_entre(){
        return $this->hasMany(AbaEntregas::class, 'perfi_entrega');
    }

    //relacion uno a muchos con Incidencias
    public function PerfilIncidencias() {
        return $this->hasMany(Incidencias::class);
    }

    //relacion muchos a uno
    public function PerfilRequisiciones() {
        return $this->hasMany(Requisiciones::class);
    }

    public function notas() {
        return $this->hasMany(notasCarga::class, 'perfil_id');
    }

    //relaciones uno a muchos inversa

    //recursividad
    public function perfiles_jefe() {
        return $this->hasMany(PerfilesUsuarios::class, 'jefe_id');
    }

    public function jefe_perfiles() {
        return $this->hasMany(PerfilesUsuarios::class, 'jefe_id')->with('perfiles_jefe');
    }

    // Relacion 1 a 1 con Puestos
    public function PerfilPuesto() {
        return $this->hasOne(Puestos::class, 'id', 'Puesto_id');
    }

    // Relacion 1 a 1 con Departamento
    public function PerfilDepartamento() {
        return $this->hasOne(Departamentos::class, 'id', 'Departamento_id');
    }

    // Relacion 1 a 1 con Departamento
    public function PerfilJefe() {
        return $this->hasOne(JefesArea::class, 'id', 'jefes_areas_id');
    }

    //Relacion 1 a mucho Equipo computo asignado
    public function EquiposComputoAsignado() {
        return $this->hasMany(PerfilesUsuarios::class, 'id');
    }


    public function parocargas_ini(){
        return $this->hasMany(parosCarga::class, 'perfil_ini_id');
    }

    public function parocargas_fin(){
        return $this->hasMany(parosCarga::class, 'perfil_fin_id');
    }

    public function SelectPerfiles(){
        return PerfilesUsuarios::get(['id','IdUser','IdEmp', 'Nombre', 'ApPat','ApMat']);
    }

}
