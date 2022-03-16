<?php

namespace App\Models\Produccion;

use App\Models\obje_cordi;
use App\Models\Produccion\catalogos\claves;
use App\Models\Produccion\catalogos\materiales;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
use phpDocumentor\Reflection\Types\This;

class dep_mat extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    // Relaciones 1 a muchos
    public function claves() {
        return $this->hasMany(claves::class);
    }

    public function cargas() {
        return $this->hasMany(carga::class, 'norma');
    }

    public function carNorm() {
        return $this->hasMany(carNorm::class, 'norma');
    }

    public function obje_cordi(){
        return $this->hasMany(obje_cordi::class, 'norma');
    }

    public function aba_entrgas(){
        return $this->hasMany(AbaEntregas::class, 'norma_id');
    }

    // Relaciones inversas 1 a muchos
    public function departamentos() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    public function materiales() {
        return $this->belongsTo(materiales::class, 'material_id');
    }
}
