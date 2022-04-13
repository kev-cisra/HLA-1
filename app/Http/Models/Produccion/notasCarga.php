<?php

namespace App\Models\Produccion;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class notasCarga extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id','created_at','updated_at'];

    //relacion uno a muchos inversa
    public function carga() {
        return $this->belongsTo(carga::class, 'carga_id');
    }

    public function perfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'perfil_id');
    }
}
