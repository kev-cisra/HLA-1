<?php

namespace App\Models\Produccion;

use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\catalogos\procesos;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class carga extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function notas(){
        return $this->hasMany(notasCarga::class, 'carga_id');
    }

    public function rela_aba_entre(){
        return $this->hasMany(rela_aba_carga::class, 'carga_id');
    }

    public function paro_obje(){
        return $this->hasMany(ParoObje::class, 'carga_id');
    }

    //relacion 1 a 1
    public function objetivopunta(){
        return $this->hasOne(ObjetivoPuntas::class, 'carga_id');
    }

    //Relacion 1 a muchos inversa
    public function dep_perf(){
        return $this->belongsTo(dep_per::class, 'dep_perf_id');
    }

    public function proceso(){
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function maq_pro() {
        return $this->belongsTo(maq_pro::class, 'maq_pro_id');
    }

    public function clave() {
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function turno() {
        return $this->belongsTo(turnos::class, 'turno_id');
    }

    public function equipo() {
        return $this->belongsTo(equipos::class, 'equipo_id');
    }

    public function dep_mat(){
        return $this->belongsTo(dep_mat::class, 'norma');
    }

    public function perfil(){
        return $this->belongsTo(PerfilesUsuarios::class, 'per_carga');
    }

    public function departamento(){
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    public function admi_aba(){
        return $this->belongsTo(admi_abas::class, 'partida_id');
    }
}
