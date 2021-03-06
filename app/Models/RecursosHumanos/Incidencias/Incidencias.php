<?php

namespace App\Models\RecursosHumanos\Incidencias;

use App\Models\RecursosHumanos\Perfiles\PerfilesUsuarios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave

class Incidencias extends Model
{
    use HasFactory;
    use SoftDeletes; //Implementamos
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['id', 'created_at','updated_at'];

    // Relacion inversa N a 1 con perfiles
    public function IncidenciaPerfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'perfiles_usuarios_id');
    }
}
