<?php

namespace App\Models;

use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\catalogos\procesos;
use App\Models\Produccion\dep_mat;
use App\Models\Produccion\maq_pro;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class obje_cordi extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    public function proceso(){
        return $this->belongsTo(procesos::class, 'proceso_id');
    }

    public function maq_pro() {
        return $this->belongsTo(maq_pro::class, 'maq_pro_id');
    }

    public function clave(){
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function dep_mat(){
        return $this->belongsTo(dep_mat::class, 'norma');
    }

    public function departamento() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }
}
