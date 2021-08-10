<?php

namespace App\Models\RecursosHumanos\Catalogos;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class JefesArea extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    // Relacion inversa 1 a 1 con departamentos
    public function JefesPerfil() {
        return $this->belongsTo(PerfilesUsuarios::class);
    }
}
