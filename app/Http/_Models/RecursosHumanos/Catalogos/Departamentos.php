<?php

namespace App\Models\RecursosHumanos\Catalogos;

use App\Models\Catalogos\Maquinas;
use App\Models\obje_cordi;
use App\Models\Produccion\Abastos\AbaEntregas;
use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\Abastos\Soli_Abas;
use App\Models\Produccion\Abastos\SoliAbas;
use App\Models\Produccion\carga;
use App\Models\Produccion\carNorm;
use App\Models\Produccion\carOpe;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\User;
use App\Models\Produccion\dep_perf;
use App\Models\Produccion\parosCarga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class Departamentos extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    // Relaciones inversas 1 a muchos
    public function dep_perfs() {
        return $this->hasMany(dep_perf::class);
    }

    public function procesos() {
        return $this->hasMany(procesos::class);
    }

    public function dep_mats() {
        return $this->hasMany(dep_mat::class);
    }

    public function maquinas() {
        return $this->hasMany(Maquinas::class);
    }

    public function puestos() {
        return $this->hasMany(Puestos::class);
    }

    public function parocargas(){
        return $this->hasMany(parosCarga::class);
    }

    public function carOpe() {
        return $this->hasMany(carOpe::class);
    }

    public function carNorm() {
        return $this->hasMany(carNorm::class);
    }

    public function obje_cordi(){
        return $this->hasMany(obje_cordi::class);
    }

    public function aba_entre_entregado(){
        return $this->hasMany(admi_abas::class, 'departamento_id');
    }

    public function depa_soli(){
        return $this->hasMany(SoliAbas::class, 'depa_solicita');
    }

    public function depa_entre(){
        return $this->hasMany(SoliAbas::class, 'depa_entregar');
    }

    public function cargas() {
        return $this->hasMany(carga::class, 'departamento_id');
    }

    public function proceCalidad(){
        return $this->hasMany(ProceCalidad::class, 'maquina_id');
    }

    // Relaciones recursiva
    public function Departamentos_sub() {
        return $this->hasMany(Departamentos::class, 'departamento_id');
    }

    public function sub_Departamentos() {
        return $this->hasMany(Departamentos::class, 'departamento_id')->with('Departamentos_sub');
    }

    // Relacion inversa 1 a 1 con departamentos
    public function Puesto_Perfil() {
        return $this->belongsTo(User::class);
    }

    public function SelectDepartamentos(){
        return Departamentos::where('id', '>', 2)->get();
    }
}
