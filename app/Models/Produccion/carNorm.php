<?php

namespace App\Models\Produccion;

use App\Models\Produccion\catalogos\claves;
use App\Models\RecursosHumanos\Catalogos\Departamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class carNorm extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    public function clave(){
        return $this->belongsTo(claves::class, 'clave_id');
    }

    public function dep_mat(){
        return $this->belongsTo(dep_mat::class, 'norma');
    }

    public function departamento() {
        return $this->belongsTo(Departamentos::class, 'departamento_id');
    }

    public function abapar() {
        return $this->belongsTo(AbaEntregas::class, 'partida_id');
    }
}
