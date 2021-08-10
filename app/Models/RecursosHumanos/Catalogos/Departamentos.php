<?php

namespace App\Models\RecursosHumanos\Catalogos;

use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\User;
use App\Models\Produccion\dep_perf;
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
}
