<?php

namespace App\Models\RecursosHumanos\Perfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria para borrado suave
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class JefeDepartamento extends Model{

    use HasFactory;
    use HasFactory;
    use SoftDeletes; //Implementamos
    use SoftCascadeTrait;

    protected $dates = ['deleted_at']; //Registramos la nueva columna
    protected $guarded = ['created_at','updated_at'];

    // Relacion inversa N a 1 con perfiles
    public function Perfil() {
        return $this->belongsTo(PerfilesUsuarios::class, 'Perfil_id');
    }

}
