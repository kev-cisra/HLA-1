<?php

namespace App\Models\Calidad;

use App\Models\Calidad\Carga\CargProcMeFibra;
use App\Models\Calidad\Catalogo\CataProceCalidad;
use App\Models\Catalogos\Maquinas;
use App\Models\Produccion\Abastos\admi_abas;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\dep_mat;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProceCalidad extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos
    public function carg_mefibra(){
        return $this->hasMany(CargProcMeFibra::class, 'proce_calidad_id');
    }

    //relacion uno a muchos inversa
    public function admi_abas(){
        return $this->belongsTo(admi_abas::class, 'partida_id');
    }

    public function clave(){
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function dep_mat(){
        return $this->belongsTo(dep_mat::class, 'dep_mat_id');
    }

    public function maquina(){
        return $this->belongsTo(Maquinas::class, 'maquina_id');
    }

    public function departaemnto(){
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    public function cat_proce_cali(){
        return $this->belongsTo(CataProceCalidad::class, 'proceso_id');
    }

    public function perfil_proc(){
        return $this->belongsTo(PerfilesUsuarios::class, 'proc_perfil_id');
    }
}
